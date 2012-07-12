<?php
session_start();
require_once('includes/config.inc.php');
require_once('includes/simple_html_dom.php');
require_once('includes/mapper.class.php');
require_once('includes/functions.inc.php');
// Create extra header information
$extraHeaderInformation = '';
$pageTitle = '';
// Include jQuery
$scripts = '<script type="text/javascript" src="https://www.google.com/jsapi"></script>
			<script type="text/javascript">
				google.load("jquery", "1.7.1");
			</script>';
// Get all settings
$mapper = new Mapper();
$settingsArray = $mapper->GetSettings();
// Extract them into variables, e.g. $template
extract($settingsArray);
unset($mapper);
// Get all the links
$mapper = new Mapper();
$linksArray = $mapper->GetLinks();
$links = '';
// Create a string with all the links as list items
foreach($linksArray as $linkArray) {
	$links .= '<a href="' . $linkArray['url'] . '" title="' . $linkArray['title'] . '"><li>' . $linkArray['name'] . '</li></a>';
}
unset($mapper);
// Get the page Id
if (isset($_GET['page'])) {
	// Get the page Id from the GET value
	$pageName = $_GET['page'];
} else {
	// No page Id is set
	$pageName = 'index.php';
}
// Check if the requests file is a directory; if so, get the index file
if (is_dir($pageName)) {
	if (substr($pageName, '-1') != '/') {
		// Add a "/" to the end of the directory name so we can look for the index file
		$pageName .= '/';
	}
	$pageName = $pageName . 'index.php';
} else if ($pageName == '') {
	// We are at the root address
	$pageName = 'index.php';
}
// Get our page variables from the database
$mapper = new Mapper();
if ($valuesArray = $mapper->GetPageContent($pageName)) {
	// Page exists in the database
	// Extract the returned array into variables
	extract($valuesArray);
	// Decode the JSON encoded page variables
	$pageVariables = json_decode($pageVariables, true);
	// Extract the page variables array into variables
	extract($pageVariables);
	// Get the page contents by using the page layout
	ob_start();
	include(PAGESFOLDER . $pageType . '.php');
	$pageContents = ob_get_clean();
} else {
	// Page does not exist in the database
	if (file_exists($pageName)) {
		// File exists on the system, load it
		ob_start();
		include($pageName);
		$pageContents = ob_get_clean();
	} else {
		// Page does not exist in the database or the system at all
		if (file_exists('404.html')) {
			$pageName = '404.html';
		} else {
			header('HTTP/1.1 404 Not Found');
		}
		exit;
	}
}
unset($mapper);
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
			var_dump($url);
			header('Location: /login.php?returnAddress=' . $url['path']);
			exit;
		}
	}
}
// Create the page title
if ($pageTitle != '') {
	$pageTitle .= ' - ' . $websiteName;
} else {
	$pageTitle = $websiteName;
}
// Create the page head
$head = $scripts;
// Create the page navigation
$navigation = '<ul>' . $links . '</ul>';
// Create the footer
$footer = $footerText;
// Create the HTML object
//$html = new simple_html_dom();
// Non-OO method
$html = file_get_html(TEMPLATESFOLDER . $template . '/index.html');
$includedTemplateFiles = $html->find('[href]');
for ($i = 0; $i < count($includedTemplateFiles); $i++) {
	$link = $includedTemplateFiles[$i];
	$href = $link->attr['href'];
	if (substr($href, 0, 1) != '/') {
		$href = '/' . $href;
	}
	$href = '/' . TEMPLATESFOLDER . $template . $href;
	$html->find('[href]', $i)->attr['href'] = $href;
}
$head .= $html->find('head', 0);
$html->find('head', 0)->innertext = $head;
// Get the elements array from the elements ini file
$elements = parse_ini_file(TEMPLATESFOLDER . $template . '/elements.ini', true);
// Replace all the elements in the ini file
foreach($elements as $element) {
	if (isset($element['replace'])) {
		$replace = $element['replace'];
	} else {
		$replace = 'full';
	}
	if (isset($$element['variable'])) {
		if ($replace == 'full') {
			if($html->find($element['name'])) {
				$html->find($element['name'], 0)->innertext = $$element['variable'];
			} else if ($html->find('div[id=' . $element['name'] . ']')) {
				$html->find('div[id=' . $element['name'] . ']', 0)->innertext = $$element['variable'];
			} else {
				echo 'Error: ' . $element['name'] . ' not found as a div or an element<br>';
			}
		} else if ($replace == 'after') {
			if($html->find($element['name'])) {
				$html->find($element['name'], 0)->innertext .= $$element['variable'];
			} else if ($html->find('div[id=' . $element['name'] . ']')) {
				$html->find('div[id=' . $element['name'] . ']', 0)->innertext .= $$element['variable'];
			} else {
				echo 'Error: ' . $element['name'] . ' not found as a div or an element<br>';
			}
		} else if ($replace == 'before') {
			if($html->find($element['name'])) {
				$html->find($element['name'], 0)->innertext = $$element['variable'] . $html->find($element['name'], 0)->innertext;
			} else if ($html->find('div[id=' . $element['name'] . ']')) {
				$html->find('div[id=' . $element['name'] . ']', 0)->innertext = $$element['variable'] . $html->find('div[id=' . $element['name'] . ']', 0)->innertext;
			} else {
				echo 'Error: ' . $element['name'] . ' not found as a div or an element<br>';
			}
		}
	} else {
		echo 'Variable ' . $element['variable'] . ' could not be found. Please check your elements.ini file.<br>';
	}
}
// Save and display the HTML
$html = $html->save();
echo $html;
?>