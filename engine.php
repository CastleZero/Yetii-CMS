<?php
session_start();
require_once('includes/config.inc.php'); /* Database connection */
require_once('includes/simple_html_dom.php'); /* Used to manipulate the supplied template */
require_once('includes/mapper.class.php'); /* Contains the mapper class used to connect to the database */
require_once('includes/functions.inc.php'); /* Contains various functions used around the site */
// Get all settings from the database (this could be removed in future in favor of only using files for configuration)
$mapper = new Mapper();
$settingsArray = $mapper->GetSettings();
// Extract them into variables, e.g. $template
extract($settingsArray);
unset($mapper);
// Get the page name
if (isset($_GET['page'])) {
	// Get the page name from the supplied GET value
	$pageName = $_GET['page'];
} else {
	// No page name is set, just fetch the index file
	$pageName = 'index.php';
}
$pageVariables = GetPage($pageName);
if ($pageVariables !== false) {
	$pageContents = $pageVariables['pageContents'];
	$requiredAuth = $pageVariables['requiredAuth'];
	$pageTitle = $pageVariables['pageTitle'];
} else {
	// Page is not a file and is not in the database, return a 404 Not Found error
	header('HTTP/1.1 404 Not Found');
	$pageName = '404.html';
	$pageVariables = GetPage($pageName);
	if ($pageVariables !== false) {
		// A 404.html file exists
		$pageContents = $pageVariables['pageContents'];
		$requiredAuth = 0;
		$pageTitle = '404 Not Found';
	} else {
		$pageContents = '404 Not Found';
		$requiredAuth = 0;
		$pageTitle = '404 Not Found';
	}
}
// Check for required permissions
if ($requiredAuth > UsersAuth()) {
	header('HTTP/1.1 403 Forbidden');
	if (isset($_SESSION['userId'])) {
		// User is logged in
		$pageVariables = GetPage('403.html');
		if ($pageVariables !== false) {
			$pageContents = $pageVariables['contents'];
		} else {
			$pageContents = '403 Forbidden';
		}
	} else {
		// User is not logged in, send them to the log in page
		$url = parse_url($_SERVER["REQUEST_URI"]);
		header('Location: /login.php?returnAddress=' . $url['path']);
		exit;
	}
}
// User has required permissions to access this page
// Get the name of the page (including the directory path) so we can check for the correct template file
if (is_dir($pageName)) {
    if (substr($pageName, '-1') != '/') {
        // Add a "/" to the end of the directory name so we can look for the index file
        $pageName .= '/';
    }
    $pageName = $pageName . 'index';
} else if ($pageName == '') {
    // We are at the root address
    $pageName = 'index';
}
$templateFile = $pageName;
var_dump($templateFile);

// if (array_key_exists('dirname', $pathInfo)) {
// 	if ($pathInfo['dirname'] == '.') {
// 		// Either top of directory (e.g. index.php) or not really a directory
// 		if (is_dir($pathInfo['dirname'])) {
// 			// Dealing with a directory
// 			if (array_key_exists('filename', $pathInfo)) {
// 				$templateFile = $pathInfo['dirname'] . '/' . $pathInfo['filename'];
// 			} else {
// 				$templateFile = $pathInfo['dirname'] . '/index.php';
// 			}
// 		} else {
// 			// Not a directory
// 		}
// 	}
// if (array_key_exists('extension', $pathInfo)) {
// 	// Getting a file
// 	$templateFile = $pathInfo['dirname'] . '/' . $pathInfo['filename'];
// } else {
// 	// Getting a folder
// 	if (array_key_exists('dirname', $pathInfo)) {
// 		$templateFile = $pathInfo['dirname'] . '/index';
// 	} else {
// 		$templateFile = 'index';
// 	}
// }
if (isset($_GET['template'])) {
	// We want a custom template
	$templateFolder = $_GET['template']; 
} else {
	$templateFolder = TEMPLATESFOLDER . $template . '/';
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
if ($pageName != '') {
	$pageTitle = $pageName . ' - ' . $websiteName;
} else {
	$pageTitle = $websiteName;
}
// Create the page head
$head = '<script type="text/javascript" src="/includes/jquery/js/jquery-1.7.2.min.js"></script>
		<script type="text/javascript" src="/includes/jquery/js/jquery-ui-1.8.21.custom.min.js"></script>';
// Non-OO method
$html = file_get_html($HTMLTemplate);
// Get all the included files (e.g. css or javascript files) and add the basepath to them so that the browser loads them correctly
$includedTemplateFiles = $html->find('[href]');
for ($i = 0; $i < count($includedTemplateFiles); $i++) {
	$link = $includedTemplateFiles[$i];
	$href = $link->attr['href'];
	if (substr($href, 0, 1) != '/') {
		$href = '/' . $href;
	}
	$href = '/' . $templateFolder . $href;
	$html->find('[href]', $i)->attr['href'] = $href;
}
// Append anything previously in the head to the custom head we already created
$head .= $html->find('head', 0)->innertext;
$html->find('head', 0)->innertext = $head;
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
				$html->find($elementName, 0)->innertext = $fillContent;
			} else if ($html->find('div[id=' . $elementName . ']')) {
				// Element has been specified via its id
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
?>