<?php
session_start();
require_once('includes/config.inc.php');
require_once('includes/simple_html_dom.php');
require_once('includes/mapper.class.php');
require_once('includes/functions.inc.php');
// Create extra header information
$extraHeaderInformation = '';
$pageTitle = '';
// Get all settings
$mapper = new Mapper();
$settingsArray = $mapper->GetSettings();
// Extract them into variables, e.g. $template
extract($settingsArray);
unset($mapper);
// Get the page Id
if (isset($_GET['page'])) {
	// Get the page Id from the GET value
	$pageName = $_GET['page'];
} else {
	// No page Id is set
	$pageName = 'index.php';
}
$pageContents = GetPage($pageName);
if ($pageContents === false) {
	// Page is not a file and is not in the database, return a 404 Not Found error
	header('HTTP/1.1 404 Not Found');
	if (file_exists('404.html')) {
		ob_start();
		include('404.html');
		$pageContents = ob_get_clean();
	} else {
		exit;
	}
}
// Check for required permissions
if (isset($requiredAuth)) {
	if ($requiredAuth > UsersAuth()) {
		header('HTTP/1.1 403 Forbidden');
		if (isset($_SESSION['userId'])) {
			// User is logged in
			if (file_exists('403.html')) {
				$pageName = '403.html';
			} else {
				echo '403 Forbidden';
				exit;
			}
		} else {
			// User is not logged in, send them to the log in page
			$url = parse_url($_SERVER["REQUEST_URI"]);
			header('Location: /login.php?returnAddress=' . $url['path']);
			exit;
		}
	}
}
if (isset($_GET['template'])) {
	// We want a custom template
	$templateFolder = $_GET['template']; 
} else {
	$templateFolder = TEMPLATESFOLDER . $template;
}
// Create the page title
if ($pageTitle != '') {
	$pageTitle .= ' - ' . $websiteName;
} else {
	$pageTitle = $websiteName;
}
// Create the page head
$head = '<script type="text/javascript" src="/includes/jquery/js/jquery-1.7.2.min.js"></script>
		<script type="text/javascript" src="/includes/jquery/js/jquery-ui-1.8.21.custom.min.js"></script>';
// Non-OO method
$html = file_get_html($templateFolder . '/index.html');
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
$elements = parse_ini_file($templateFolder . '/elements.ini', true);
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