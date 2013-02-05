<?php
session_start();
// Check if we're in maintenance mode
if (is_file('maintenance')) {
	header('HTTP/1.1 503 Service Unavailable');
	echo file_get_contents('maintenance');
	exit;
}
if (!is_file('includes/config.inc.php')) {
	if ($_GET['page'] == 'install.php') {
		echo eval('?>' . file_get_contents('install.php'));
	} else {
		header('Location: install.php');
		echo 'No config file was found. Please <a href="install.php">install Yetii CMS</a>.<br>';
	}
	exit;
} else {
	require_once('includes/config.inc.php'); /* Database connection */
}
require_once('includes/simple_html_dom.php'); /* Used to manipulate the supplied template */
require_once('includes/mapper.class.php'); /* Contains the mapper class used to connect to the database */
require_once('includes/functions.inc.php'); /* Contains various functions used around the site */
require_once('includes/page.class.php'); /* Contains the page class used to create a page */
require_once('includes/snippet.class.php'); /* Contains the class used to display snippets */
require_once('includes/yetii.class.php');
require_once('includes/restrequest.class.php');
// Disable magic quotes gpc
if (get_magic_quotes_gpc()) {
    $process = array(&$_GET, &$_POST, &$_COOKIE, &$_REQUEST);
    while (list($key, $val) = each($process)) {
        foreach ($val as $k => $v) {
            unset($process[$key][$k]);
            if (is_array($v)) {
                $process[$key][stripslashes($k)] = $v;
                $process[] = &$process[$key][stripslashes($k)];
            } else {
                $process[$key][stripslashes($k)] = stripslashes($v);
            }
        }
    }
    unset($process);
}
$yetii = new Yetii();
$yetii->loadSettings();
// Get the page name
if (isset($_GET['page'])) {
	// Get the page name from the supplied GET value
	$pageURL = $_GET['page'];
} else {
	// No page name is set, just fetch the index file
	$pageURL = 'index.php';
}
$page = new Page();
$page->load($pageURL, true);
if ($page->useEngine) {
	// Page being loaded wants to use the engine to be rendered
	if ($page->header) {
		header($page->header);
	}
	if ($page->redirectTo) {
		// Page is being redirected
		header('Location: ' . $page->redirectTo);
		exit;
	}
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
	if (isset($_GET['template']) && is_dir(TEMPLATESFOLDER . $_GET['template'])) {
		// We want a custom template
		$templateFolder = TEMPLATESFOLDER . $_GET['template'] . '/'; 
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
	// Add the meta description to the header
	$changedMetaDescription = false;
	foreach ($html->find('meta') as $metaTag) {
		if (array_key_exists('name', $metaTag->attr)) {
			if ($metaTag->attr['name'] == 'description') {
				if (array_key_exists('content', $metaTag->attr)) {
					$metaTag->attr['content'] = $page->metaDescription;
				} else {
					$metaTag->attr['content'] = $page->metaDescription;
				}
				$changedMetaDescription = true;
			}
		}
	}
	if (!$changedMetaDescription) {
		$totalMetaTags = count($html->find('meta'));
		$html->find('meta', $totalMetaTags -1)->outertext = $html->find('meta', $totalMetaTags -1)->outertext . '<meta name="description" content="' . $page->metaDescription . '">';
	}
	// Add required script files
	$includeScripts = array('jquery', 'jqueryui');
	foreach ($includeScripts as $script) {
		switch ($script) {
			case 'jquery':
				$html->find('head', 0)->innertext .= '<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>';
				break;
			case 'jqueryui':
				$html->find('head', 0)->innertext .= '<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js"></script>';
				break;
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
				$fillContent = 'snippet[' . $element['snippet'] . ']';
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
						$fillContent .= $html->find($elementName, 0)->innertext;
					}
					$html->find($elementName, 0)->innertext = $fillContent;
				} else if ($html->find('#' . $elementName)) {
					// Element has been specified via its id
					foreach ($html->find('#' . $elementName) as $element) {
						if ($replace == 'after') {
							$fillContent = $element->innertext . $fillContent;
						} else if ($replace == 'before') {
							$fillContent .= $element->innertext;
						}
						$element->innertext = $fillContent;
					}
				} else {
					echo 'There was an error in the ini file for the template; "' . $elementName . '" could not be found in the HTML file.<br>';
				}
			}
		} else {
			echo 'There was an error in the ini file for the template: An element did not have an "element" value. Please check your ini file<br>';
		}
	}
	// Get all the included files (e.g. css or javascript files) and add the templates URL to them so that the browser loads them correctly
	$html->find('html', 0)->innertext = preg_replace_callback('/[<img|<script][^>]+src\s*=\s*[\'"]([^\'"]+)[\'"][^>]*>/', 'addFilePaths', $html->find('html', 0)->innertext);
	$html->find('html', 0)->innertext = preg_replace_callback('/<link[^>]+href\s*=\s*[\'"]([^\'"]+)[\'"][^>]*>/', 'addFilePaths', $html->find('html', 0)->innertext);
	// Replace snippets
	if (!($pageURL == 'admin/pages' || $pageURL == 'admin/pages.php')) {
		$html->find('html', 0)->innertext = preg_replace_callback('/(?<!dummy_)(snippet\[(.*?)\])/', 'getSnippetCode', $html->innertext);
		$html->find('html', 0)->innertext = preg_replace('/(dummy_)(snippet\[(.*?)\])/', '$2', $html->innertext);
	}
	// Save and display the HTML
	$html = $html->save();
	echo $html;
} else {
	// Page being loaded does not need to use the engine
	echo $page->contents;
}
?>