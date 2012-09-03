<?php

class Page {
	public $url, $name, $contents, $metaDescription, $savedTo, $header, $redirectTo;
	public $requiredAuth = 0;
	public $useEngine = true;

	/**
	*
	* @author Joseph Duffy
	* @version 1.2
	* @var url string The URL of the page to get
	* @var parsed bool Whether the page should be parsed, or returned in its original (code) form
	* @return bool If the page was loaded successfully
	*/
	public function LoadPage($url, $parsed = true) {
		$this->url = $url;
		$mapper = new Mapper();
		$pageVariables = $mapper->GetPage($this->url);
		unset($mapper);
		if ($pageVariables === false) {
			// Page was not found in the database, check for a file with that url
			// Check if the requests file is a directory; if so, get the index file
		    if (is_dir($this->url)) {
		        if (substr($this->url, '-1') != '/') {
		            // Add a "/" to the end of the directory name so we can look for the index file
		            $this->url .= '/';
		        }
		        $this->url = $this->url . 'index.php';
		    } else if ($this->url == '') {
		        // We are at the root address
		        $this->url = 'index.php';
		    }
		    $pageVariables = array();
		    // Get the page contents by first checking if the requested file is a file. If it is not, check if the file is in the database. If it is neither, return false
		    if (file_exists($this->url) || file_exists($this->url . '.php')) {
		        $this->savedTo = 'file';
		        if (!file_exists($this->url)) {
		            $this->url = $this->url . '.php';
		        }
		        // File exists on the system, load it
		        $fileContents = file_get_contents($this->url);
		        if ($parsed) {
		            ob_start();
		            include($this->url);
		            $this->contents = ob_get_clean();
		            if (isset($pageName)) {
		                $this->name = $pageName;
		            }
		            if (isset($requiredAuth)) {
		                $this->requiredAuth = $requiredAuth;
		            }
		            if (isset($useEngine)) {
		                $this->useEngine = $useEngine;
		            }
		        } else {
		            $this->contents = $fileContents;
		        }
		    } else {
		    	$this->name = '404 Not Found';
		    	$this->contents = '404 Not Found';
		    	$this->header = 'HTTP/1.1 404 Not Found';
		    	return false;
		    }
		} else {
			// Page was found in the database
			$this->savedTo = 'database';
			$this->name = $pageVariables['name'];
			$this->requiredAuth = $pageVariables['requiredAuth'];
			if ($parsed) {
				ob_start();
	            eval('?>' . $pageVariables['content']);
	            $this->contents = ob_get_clean();
			} else {
				$this->contents = $pageVariables['content'];
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
				$this->redirectTo = '/login.php?returnAddress=' . $url['path'];
			}
		}
	}
}
?>