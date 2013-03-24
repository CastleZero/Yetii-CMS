<?php
/**
 * Page class
 *
 * @category Class
 * @author Joseph Duffy <JosephDuffy@me.com>
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License
 */
class Page {
    private $url, $name, $title, $html, $contents, $metaDescription = false, $savedTo, $template = TEMPLATE, $templatePageName, $templateFile, $header = false, $redirectTo, $requiredAuth = 0, $useEngine = true, $newURL = false, $urlChanged = false;

    public function __get($name) {
        return $this->$name;
    }

    /**
    * Loads a page with the provided url
    * Page does not always have its (PHP) code parsed
    * @var    String $url      The URL of the page to get
    * @var    bool   $parsed   Whether the page should be parsed, or returned in its original (code) form
    * @var    bool   $parsedDB Whether a page stored in the DB should have PHP code parsed (possible security risk)
    * @return bool             If the page was loaded successfully
    */
    public function load($url, $parsed = false, $parseDB = false) {
        $this->url = $url;
        if (INSTALLURL !== '') {
            // Yetii is not installed in the website root
            if (strpos($this->url, INSTALLURL) === 0) {
                // URL is a Yetii URL (e.g. "INSTALLURL/admin"), remove the INSTALLURL
                $this->url = str_replace(INSTALLURL, '', $this->url);
                $filePrefix = '';
            } else {
                // URL is not a Yetii URL
                $folderLevels = substr_count(ROOTURL . INSTALLURL, '/');
                $filePrefix = '';
                for ($i = 0; $i < $folderLevels; $i++) {
                    $filePrefix  = $filePrefix  . '.';
                }
                $filePrefix = $filePrefix . '/';
            }
        } else {
            $filePrefix = '';
        }
        // Check if the requests file is a directory. If so, get the index file
        if ($this->url == '') {
            // We are at the root address
            $this->url = 'index.php';
        }
        $pageVariables = array();
        // Get the page contents by first checking if the requested file is a file. If it is not, check if the file is in the database. If it is neither, return false
        if (file_exists($filePrefix . $this->url)) {
            // Page exists on the file system
            $this->savedTo = 'file';
            // File exists on the system, load it
            if ($parsed) {
                // Store the current working directory so we can switch back to it
                $oldDir = getcwd();
                if (isset($folderLevels)) {
                    $dots = '';
                    for ($i = 0; $i < $folderLevels; $i++) {
                        $dots = $dots . '.';
                    }
                    // Change the directory so we're working relative to non-yetii file
                    chdir($dots . '/');
                }
                ob_start();
                include($this->url);
                $this->contents = ob_get_clean();
                chdir($oldDir);
                if (isset($pageName)) {
                    $this->name = $pageName;
                }
                if (isset($requiredAuth)) {
                    $this->requiredAuth = $requiredAuth;
                }
                // Set the required auth for all admin pages to 3
                if (substr($this->url, 0, strlen(ADMINFOLDER)) == ADMINFOLDER) {
                    $this->requiredAuth = 3;
                }
                if (isset($useEngine)) {
                    $this->useEngine = $useEngine;
                }
                if (isset($metaDescription)) {
                    $this->metaDescription = $metaDescription;
                }
                if (isset($template)) {
                    $this->template = $template;
                }
            } else {
                $this->contents = file_get_contents($filePrefix . $this->url);
            }
        } else {
            // Look for the page in the database
            $mapper = new Mapper();
            $pageVariables = $mapper->GetPage($this->url);
            unset($mapper);
            if ($pageVariables !== false) {
                // Page was found in the database
                $this->savedTo = 'database';
                $this->name = $pageVariables['name'];
                $this->requiredAuth = $pageVariables['requiredAuth'];
                $this->metaDescription = $pageVariables['metaDescription'];
                if ($parsed && $parseDB) {
                    if (!is_dir(TEMPDIRECTORY)) {
                        mkdir(TEMPDIRECTORY);
                    }
                    $randomFileName = generateRandomString(8) . '.php';
                    while (is_file(TEMPDIRECTORY . $randomFileName)) {
                        $randomFileName = generateRandomString(8) . '.php';
                    }
                    file_put_contents(TEMPDIRECTORY . $randomFileName, $pageVariables['content']);
                    ob_start();
                    require_once(TEMPDIRECTORY . $randomFileName);
                    $result = ob_get_clean();
                    unlink(TEMPDIRECTORY . $randomFileName);
                    if ($result == '') {
                        // There was an error in the code
                        if (UsersAuth() > 2) {
                            $this->contents = 'The code for this page caused an error. Please review it.<br>' . eval('?>' . $pageVariables['content']);
                        } else {
                            $this->contents = 'There is an error in the code for this page. You require higher permissions to view this error.<br>';
                        }
                    } else {
                        // Display the page if there are no errors
                        $this->contents = $result;
                    }
                } else {
                    $this->contents = $pageVariables['content'];
                }
            } else {
                // Page was not found in the database, return status 404
                $this->name = '404 Not Found';
                $this->contents = '404 Not Found';
                $this->header = 'HTTP/1.1 404 Not Found';
                return false;
            }
        }
        if ($this->requiredAuth > UsersAuth()) {
            $this->name = '403 Forbidden';
            $this->contents = '403 Forbidden';
            if (isset($_SESSION['userId'])) {
                // User is logged in
                $this->header = 'HTTP/1.1 403 Forbidden';
            } else {
                // User is not logged in, send them to the log in page
                $url = parse_url($this->url);
                $this->header = 'HTTP/1.1 403 Forbidden';
                $this->redirectTo = ROOTURL . 'login.php?returnAddress=' . $url['path'];
            }
            return false;
        }
    }

    /**
     * Saves the page to the disk or database
     * Updates the URL is the URL have changes
     */
    public function save() {
        $errors = array();
        if ($this->newURL !== false) {
            // Updating the pages URL
            $newPage = new Page();
            if ($newPage->load($this->newURL) !== false) {
                $error = array('fieldId' => 'pageURL', 'message' => 'The chosen URL is already taken. Please chose another URL.');
                array_push($errors, $error);
            }
            unset($newPage);
        }
        if (count($errors) > 0) {
            showErrors($errors);
        } else {
            // Page URL is valid
            if ($this->savedTo == 'database') {
                // Page is stored in a database
                $mapper = new Mapper();
                if ($mapper->savePage($this->url, $this->name, $this->requiredAuth, $this->contents, $this->metaDescription)) {
                    echo 'Page has been saved!<br>';
                } else {
                    $error = array('fieldId' => 'pageURL', 'message' => 'There was an error saving the page\'s properties');
                    array_push($errors, $error);
                    showErrors($errors);
                }
                if ($this->newURL !== false) {
                    // Try to update the page's URL
                    if ($mapper->changePageURL($this->url, $this->newURL)) {
                        echo 'Page URL has been updated. You can <a href="pages.php?pageURL=' . $this->newURL . '">edit the page using its new URL</a>.<br>';
                        $this->urlChanged = true;
                    } else {
                        $error = array('fieldId' => 'url', 'message' => 'The Page URL could not be updated');
                        array_push($errors, $error);
                        showErrors($errors);
                        unset($mapper);
                    }
                }
                unset($mapper);
            } else {
                // Save the page to a file
                if (file_put_contents($this->url, $this->contents)) {
                    echo 'Page saved!.<br>';
                } else {
                    echo 'There was error saving the file. Please try again.<br>';
                }
                if ($this->newURL !== false) {
                    // Try to update the page's URL
                    if (rename($this->url, $this->newURL)) {
                        echo 'Page URL has been updated. You can <a href="pages.php?pageURL=' . $this->newURL . '">edit the page using its new URL</a>.<br>';
                        $this->urlChanged = true;
                    } else {
                        $error = array('fieldId' => 'url', 'message' => 'The Page URL could not be updated');
                        array_push($errors, $error);
                        showErrors($errors);
                    }
                }
            }
        }
    }

    /**
     * Calculates the templatePageName, template and templateFile for the page
     * @param  String $template The (optional) name of the template to use
     */
    public function generateTemplateInformation($template = false) {
        if (is_dir($this->url)) {
            if (substr($this->url, '-1') != '/') {
                // Add "/index" to the end of the url to get the index file of that directory
                $this->templatePageName = $this->url . '/index';
            } else {
                $this->templatePageName = $this->url . 'index';
            }
        } else if (substr($this->url, 5) == 'index') {
            // We are at the root address, set the template name to index
            $this->templatePageName = 'index';
        } else {
            if (array_key_exists('extension', pathinfo($this->url))) {
                // Page has been loaded with an extension (.php or .html)
                $pageFileInfo = pathinfo($this->url);
                if ($pageFileInfo['dirname'] == '.') {
                    // Page is in the root of the website
                    $this->templatePageName = $pageFileInfo['filename'];
                } else {
                    // Page is in a subdirectory of the root
                    $this->templatePageName = $pageFileInfo['dirname'] . '/' . $pageFileInfo['filename'];
                }
            } else {
                // Page does not have an extension, so the template file name is correct already
                $this->templatePageName = $this->url;
            }
        }
        if ($template !== false) {
            // Template has been set via the URL
            $this->template = $template;
        }
        // Check which (if any) templates are available
        if (is_file(TEMPLATESFOLDER . $this->template . '/' . $this->templatePageName . '.html')
            && is_file(TEMPLATESFOLDER . $this->template . '/' . $this->templatePageName . '.ini')) {
            // The template and page name associated with the page exists
            $this->templateFile = TEMPLATESFOLDER . $this->template . '/' . $this->templatePageName;
        } else if (is_file(TEMPLATESFOLDER . $this->template . '/default.html') && is_file(TEMPLATESFOLDER . $this->template . '/default.ini')) {
            // There's at least a default page for the chosen template
            $this->templateFile = TEMPLATESFOLDER . $this->template . '/default';
        } else if (is_file(TEMPLATESFOLDER . TEMPLATE . '/default.html') && is_file(TEMPLATESFOLDER . TEMPLATE . '/defauls.ini')) {
            // Page's template is invalid, but the default one is not
            $this->templateFile = TEMPLATESFOLDER . TEMPLATE . '/default';
        } else {
            // Neither the page's template nor the default template are valid
            if ($this->template == TEMPLATE) {
                echo 'No default.html and/or no default.ini file was found for the template "' . $this->template . '". Please fix this by choosing a valid template in the settings.';
            } else {
                echo 'No default.html and/or no default.ini file was found for the template "' . $this->template . '", or the default template "' . TEMPLATE . '". Please fix this by choosing a valid template in the settings.';
            }
            exit;
        }
    }

    /**
     * Creates the title for the page and defines PAGENAME
     * If no page name is set the websites title is used for the page title
     */
    public function generateTitle() {
        if ($this->name !== null) {
            define('PAGENAME', $this->name);
            $this->title = $this->name . ' - ' . WEBSITENAME;
        } else {
            define('PAGENAME', NULL);
            $this->title = WEBSITENAME;
        }
    }

    /**
     * Loads the HTML file from the current template file
     */
    public function loadHTMLTemplate() {
        $this->html = file_get_html($this->templateFile . '.html');
    }

    /**
     * Replaces the html title tag with the title of the page
     */
    public function replaceTitle() {
        $this->html->find('head', 0)->find('title', 0)->innertext = $this->title;
    }

    /**
     * Adds the meta description to the page if the meta description has been set
     * If no meta tag is present one is created
     */
    public function addMetaDescription() {
        if ($this->metaDescription !== false) {
            $changedMetaDescription = false;
            foreach ($this->html->find('meta') as $metaTag) {
                if (array_key_exists('name', $metaTag->attr) && $metaTag->attr['name'] == 'description') {
                    // meta tag has the description attribute
                    $metaTag->attr['content'] = $this->metaDescription;
                    $changedMetaDescription = true;
                }
            }
            if (!$changedMetaDescription) {
                // No meta description tag exists in the template file
                $totalMetaTags = count($this->html->find('meta'));
                if ($totalMetaTags < 0) {
                    // Add the meta description to the end of the other meta tags
                    $this->html->find('meta', $totalMetaTags - 1)->outertext .= '<meta name="description" content="' . $this->metaDescription . '">';
                } else {
                    // No other meta tags exist, so add it to the start of the head
                    $this->html->find('head', 0)->innertext = '<meta name="description" content="' . $this->metaDescription . '">' . $this->html->find('head', 0)->innertext;
                }
            }
        }
    }

    /**
     * Adds any external JavaScript libraries to the pages head.
     * Currently adds jQuery and jQueryUI to all pages
     */
    public function addScripts() {
        $includeScripts = array('jquery', 'jqueryui');
        foreach ($includeScripts as $script) {
            switch ($script) {
                case 'jquery':
                    $this->html->find('head', 0)->innertext .= '<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>';
                    break;
                case 'jqueryui':
                    $this->html->find('head', 0)->innertext .= '<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js"></script>';
                    break;
            }
        }
    }

    /**
     * Adds any extra header information is set via the $header variable in the page
     */
    public function addExtraHeaderInformation() {
        if ($this->header !== false) {
            $this->html->find('head', 0)->innertext .= $this->header;
        }
    }

    /**
     * Replace all variables and snippets stored in the INI file for the template
     */
    public function replaceINI() {
        // Get the elements array from the templates ini file in a multidimentional array
        $elements = parse_ini_file($this->templateFile . '.ini', true);
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
                    if (isset($this->$variable)) {
                        $fillContent = $this->$variable;
                    } else {
                        echo 'There was an error in the ini file for the template; The variable "' . $variable . '" is not a valid variable for this page.<br>';
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
                    if ($this->html->find($elementName)) {
                        // Element is a default element (e.g. <title>, <header> or <nav>)
                        foreach ($this->html->find($elementName) as $element) {
                            if ($replace == 'after') {
                                $fillContent = $element->innertext . $fillContent;
                            } else if ($replace == 'before') {
                                $fillContent .= $element->innertext;
                            }
                            $element->innertext = $fillContent;
                        }
                    } else if ($this->html->find('#' . $elementName)) {
                        // Element has been specified via its id
                        foreach ($this->html->find('#' . $elementName) as $element) {
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
    }

    /**
     * Finds all the files in the template HTML file and replaces the url so they can be loaded by the browser
     * @see  addFilePaths()
     */
    public function addPathToTemplateFiles() {
        // Replace img and script tags src attribute
        $this->html->find('html', 0)->innertext = preg_replace_callback('/[<img|<script][^>]+src\s*=\s*[\'"]([^\'"]+)[\'"][^>]*>/', array(&$this, 'addFilePaths'), $this->html->find('html', 0)->innertext);
        // Replace link tags href attribute
        $this->html->find('html', 0)->innertext = preg_replace_callback('/<link[^>]+href\s*=\s*[\'"]([^\'"]+)[\'"][^>]*>/', array(&$this, 'addFilePaths'), $this->html->find('html', 0)->innertext);
    }

    /**
     * Adds the path of the template to any files with a path relative to the template so they will be loaded by the browser
     * @see   addPathToTemplateFiles()
     * @param String $url The img, script or link's src or href attribute
     */
    private function addFilePaths($url) {
        if (substr($url[1], 0, 1) != '/' && substr($url[1], 0, 4) != 'http') {
            // Only replace files that are relative to the template folder
            $newurl = str_replace($url[1], ROOTURL . INSTALLURL . TEMPLATESFOLDER . $this->template . '/' . $url[1], $url[0]);
        } else {
            $newurl = $url[0];
        }
        return $newurl;
    }

    /**
     * Replaces snippets on the current page with the code that snippet produces
     * and removes the "_dummy" from dummy snippets
     */
    public function replaceSnippets() {
        // Replace non-dummy snippets
        $this->html->find('html', 0)->innertext = preg_replace_callback('/(?<!dummy_)(snippet\[(.*?)\])/', 'getSnippetCode', $this->html->find('html', 0)->innertext);
        // Remove the "dummy_" from dummy snippets
        $this->html->find('html', 0)->innertext = preg_replace('/(dummy_)(snippet\[(.*?)\])/', '$2', $this->html->find('html', 0)->innertext);
    }

    /**
     * Replaces any snippets code in the page's contents with a dummy version of that snippet
     */
    public function dummifySnippets() {
        $this->contents = preg_replace('/(snippet\[(.*?)\])/', 'dummy_$1', $this->contents);
    }

    /**
     * Save the HTML object
     */
    public function saveHTML() {
        $this->html = $this->html->save();
    }

    public function getURL() {
        return $this->url;
    }

    public function getName() {
        return $this->name;
    }

    public function getRequiredAuth() {
        return $this->requiredAuth;
    }

    public function getContents() {
        return $this->contents;
    }

    public function getMetaDescription() {
        return $this->metaDescription;
    }

    public function getURLChanged() {
        return $this->urlChanged;
    }

    public function setURL($url) {
        if ($url != $this->url) {
            // URL is being updated
            $this->newURL = $url;
        }
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function setRequiredAuth($requiredAuth) {
        $this->requiredAuth = $requiredAuth;
    }

    public function setContents($contents) {
        $this->contents = $contents;
    }

    public function setMetaDescription($metaDescription) {
        $this->metaDescription = $metaDescription;
    }
}
?>