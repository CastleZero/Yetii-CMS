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
unset($yetii);
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
	if ($page->header !== false) {
		header($page->header);
	}
	if ($page->redirectTo) {
		// Page is being redirected
		header('Location: ' . $page->redirectTo);
		exit;
	}
	// Get the name of the template requested via GET. If no template is requested set the template to false
	$template = (isset($_GET['template'])) ? $_GET['template'] : false;
	$page->generateTemplateInformation($template);
	// Generate the title for the page and define the name as a constant
	$page->generateTitle();
	// Load the HTML template
	$page->loadHTMLTemplate();
	// Replace the page title. Only seems to work if it's (one of) the first things to get altered. Odd.
	$page->replaceTitle();
	// Add the meta description
	$page->addMetaDescription();
	// Add required script files
	$page->addScripts();
	// Add an extra header information
	$page->addExtraHeaderInformation();
	// Replace elements in the ini file
	$page->replaceINI();
	// Add paths to the templates files (e.g. /templates/themename/ to css files)
	$page->addPathToTemplateFiles();
	// Replace snippets
	$page->replaceSnippets();
	// Save the HTML
	$page->saveHTML();
	// Display the HTML
	echo $page->html;
} else {
	// Page being loaded does not need to use the engine
	echo $page->contents;
}
?>