<?php
session_start();
// Check if we're in maintenance mode
if (is_file('maintenance')) {
	header('HTTP/1.1 503 Service Unavailable');
	echo file_get_contents('maintenance');
	exit;
}
require_once('includes/config.inc.php'); /* Database connection */
require_once('includes/simple_html_dom.php'); /* Used to manipulate the supplied template */
require_once('includes/mapper.class.php'); /* Contains the mapper class used to connect to the database */
require_once('includes/functions.inc.php'); /* Contains various functions used around the site */
require_once('includes/page.class.php'); /* Contains the page class used to create a page */
// Get the page name
if (isset($_GET['page'])) {
	// Get the page name from the supplied GET value
	$pageURL = $_GET['page'];
} else {
	// No page name is set, just fetch the index file
	$pageURL = 'index.php';
}
$page = new Page();
$page->LoadPage($pageURL);
if ($page->header) {
	header($page->header);
}
if ($page->redirectTo) {
	// Page is being redirected
	header('Location: ' . $page->redirectTo);
	exit;
}
if ($page->useEngine) {
	// Page being loaded wants to use the engine to be rendered
	// Get the name of the page (including the directory path) so we can check for the correct template file
	if (is_dir($pageURL)) {
	    if (substr($pageURL, '-1') != '/') {
	        // Add a "/" to the end of the directory name so we can look for the index file
	        $pageURL .= '/';
	    }
	    $pageURL = $pageURL . 'index';
	} else if ($pageURL == '') {
	    // We are at the root address
	    $pageURL = 'index';
	}
	if (array_key_exists('extension', pathinfo($pageURL))) {
		$pageFileInfo = pathinfo($pageURL);
		if ($pageFileInfo['dirname'] == '.') {
			$templateFile = $pageFileInfo['filename'];
		} else {
			$templateFile = $pageFileInfo['dirname'] . '/' . $pageFileInfo['filename'];
		}
	} else {
		$templateFile = $pageURL;
	}
	if (isset($_GET['template']) && is_dir($_GET['template'])) {
		// We want a custom template
		$templateFolder = $_GET['template']; 
	} else {
		$templateFolder = TEMPLATESFOLDER . TEMPLATE . '/';
	}
	// Check which (if any) templates are available
	if (is_file($templateFolder . $templateFile . '.html') && is_file($templateFolder . $templateFile . '.ini')) {
		$HTMLTemplate = $templateFolder . $templateFile . '.html';
		$INITemplate = $templateFolder . $templateFile . '.ini';
	} else if (is_file($templateFolder . 'default.html') && is_file($templateFolder . 'default.ini')) {
		$HTMLTemplate = $templateFolder . 'default.html';
		$INITemplate = $templateFolder . 'default.ini';
	} else {
		echo 'Either no default.html or no default.ini file was found in "' . $templateFolder . '". Please fix this by choosing a valid theme in the settings.';
		exit;
	}
	// Create the page title
	if ($page->name !== null) {
		$pageTitle = $page->name . ' - ' . WEBSITENAME;
	} else {
		$pageTitle = WEBSITENAME;
	}
	// Create the page contents
	$pageContents = $page->contents;
	// Non-OO method
	$html = file_get_html($HTMLTemplate);
	// Get all the included files (e.g. css or javascript files) and add the basepath to them so that the browser loads them correctly
	$includedTemplateFiles = $html->find('[href]');
	for ($i = 0; $i < count($includedTemplateFiles); $i++) {
		$link = $includedTemplateFiles[$i];
		$href = $link->attr['href'];
		if (substr($href, 0, 1) != '/') {
			// Only replace files that are relative to the template folder
			$href = '/' . $templateFolder . '/' . $href;
			$html->find('[href]', $i)->attr['href'] = $href;
		}
	}
	// Get the elements array from the elements.ini file
	$elements = parse_ini_file($INITemplate, true);
	// Replace all the elements in the ini file
	foreach ($elements as $element) {
		if (array_key_exists('element', $element)) {
			$elementName = $element['element'];
			if (isset($element['replace'])) {
				$replace = $element['replace'];
			} else {
				$replace = 'full';
			}
			if (array_key_exists('variable', $element)) {
				// Replacing an element with a variable
				$variable = $element['variable'];
				if (isset($$variable)) {
					$fillContent = $$variable;
				} else {
					echo 'There was an error in the ini file for the template; The variable "' . $variable . '" could not be found.<br>';
				}
			} else if (array_key_exists('snippet', $element)) {
				// Replace an element with a snippet
				$snippet = $element['snippet'];
				$fillContent = GetSnippet($snippet);
			} else {
				// No valid replacement was found
				echo 'There was an error in the ini file for the template; "' . $elementName . '" did not have a value to be filled with.<br>';
			}
			if (isset($fillContent)) {
				// We have content to fill, try and find the element
				if ($html->find($elementName)) {
					// Element is a default element (e.g. <title>, <header> or <nav>)
					if ($replace == 'after') {
						$fillContent = $html->find($elementName, 0)->innertext . $fillContent;
					} else if ($replace == 'before') {
						$fillContent = $fillContent . $html->find($elementName, 0)->innertext;
					}
					$html->find($elementName, 0)->innertext = $fillContent;
				} else if ($html->find('div[id=' . $elementName . ']')) {
					// Element has been specified via its id
					if ($replace == 'after') {
						$fillContent = $html->find('div[id=' . $elementName . ']', 0)->innertext . $fillContent;
					} else if ($replace == 'before') {
						$fillContent = $fillContent . $html->find('div[id=' . $elementName . ']', 0)->innertext;
					}
					$html->find('div[id=' . $elementName . ']', 0)->innertext = $fillContent;
				} else {
					echo 'There was an error in the ini file for the template; "' . $elementName . '" could not be found in the HTML file.<br>';
				}
			}
		} else {
			echo 'There was an error in the ini file for the template: An element did not have an "element" value. Please check your ini file<br>';
		}
	}
	// Save and display the HTML
	$html = $html->save();
	echo $html;
} else {
	// Page being loaded does not need to use the engine
	echo $pageContents;
}
?>