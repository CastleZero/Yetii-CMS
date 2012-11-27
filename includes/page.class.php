<?php

class Page {
	public $url, $name, $contents, $metaDescription, $savedTo, $header, $redirectTo, $requiredAuth = 0, $useEngine = true;

	/**
	*
	* @author Joseph Duffy
	* @version 1.0
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
		    if (INSTALLURL !== '') {
		    	// Yetii is not installed in the website root
		    	if (strpos($this->url, INSTALLURL) === 0) {
		    		// URL is a Yetii URL (e.g. not admin), remove the INSTALLURL
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
		    if (file_exists($filePrefix . $this->url) || file_exists($filePrefix . $this->url . '.php')) {
		        $this->savedTo = 'file';
		        if (!file_exists($filePrefix . $this->url)) {
		        	// File does not have a .php extension
		            $this->url = $this->url . '.php';
		        }
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
		            if (isset($useEngine)) {
		                $this->useEngine = $useEngine;
		            }
		            if (isset($metaDescription)) {
		            	$this->metaDescription = $metaDescription;
		            }
		        } else {
		            $this->contents = file_get_contents($filePrefix . $this->url);
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
			$this->metaDescription = $pageVariables['metaDescription'];
			if ($parsed) {
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
			return false;
		}
	}
}
?>