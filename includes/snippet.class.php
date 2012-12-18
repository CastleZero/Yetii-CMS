<?php

class Snippet {
	private $name, $properties, $contents, $configurationPage = false, $error = false, $editing, $snippetLocation, $passedVariables, $storedVariables = false, $loaded = false;

	public function load($snippet, $editingSnippet = false, $variables = array(), $code = false) {
		$this->name = $snippet;
	    $this->snippetLocation = SNIPPETSFOLDER . $snippet;
	    $passedVariables = $variables;
	    $this->editing = $editingSnippet;
	    if (is_dir($this->snippetLocation)) {
	        // The snippet provided was valid, check for an index file
	        if (is_file($this->snippetLocation . '/index.php')) {
	        	$this->snippetFile = $this->snippetLocation . '/index.php';
	            // An index file was provided
	            if (is_file($this->snippetLocation . '/' . $this->name . '.ini')) {
	            	$this->properties = parse_ini_file($this->snippetLocation . '/' . $this->name . '.ini', true);
	            	if ($this->properties['storageType'] == 'ini') {
	            		// Try and load the snippets variables
	            		$this->isDynamic = true;
	            		if (isset($this->properties['variablesFile'])) {
	            			// Load variable from a file
	            			if (is_file($this->snippetLocation . '/' . $this->properties['variablesFile'])) {
	            				$this->variablesFile = $this->snippetLocation . '/' . $this->properties['variablesFile'];
		            			$this->storedVariables = parse_ini_file($this->variablesFile);
		            		} else {
		            			$this->error = 'A storage type of file was found, but the file "' . $this->properties['variablesFile'] . '" is not valid.';
		            		}
	            		}
	            	} else if ($this->properties['storageType'] == 'database') {
            			$this->isDynamic = true;
            		} else {
            			$this->isDynamic = false;
            		}
            		if ($this->isDynamic) {
            			$this->configurationPage = $this->snippetLocation . '/' . $this->properties['configurationPage'];
            			if (!is_file($this->configurationPage)) {
            				$this->error = 'The snippet is dynamic but the configuration file "' . $this->properties['configurationPage'] . '" could not be found.';
            			}
            		}
	            } else {
	            	$this->isDynamic = false;
	            }
	        } else {
	            // No index.php is present, the snippet is not valid
	            $this->error = 'No index.php file was present.';
	        }
	    } else {
	        // Supplied snippet is not a valid folder
	        $this->error = '"' . $snippet . '" could not be found in the snippets folder.';
	    }
	    if ($this->editing) {
	    	// Editing the snippet
	    	if ($this->isDynamic) {
	        	$this->contents = file_get_contents($this->configurationPage);
	        } else {
	        	if (!$code) {
	        		$this->contents = file_get_contents($this->snippetLocation . '/index.php');
	        	} else {
	        		$this->contents = $code;
	        	}
	        }
	    } else {
	        // Not editing the snippet
	    	ob_start();
	        if ($this->storedVariables) {
	            extract($this->storedVariables);
	        }
	        require($this->snippetFile);
	        $this->contents = ob_get_clean();
	    }
	    $this->loaded = true;
	    return true;
	}

	public function save($code) {
		if ($this->isDynamic) {
			echo 'Dynamic snippets cannot be saved.';
			return false;
		} else {
			if (file_put_contents($this->snippetLocation . '/index.php', $code)) {
				return true;
			} else {
				return false;
			}
		}
	}

	public function getName() {
		return $this->name;
	}

	public function getError() {
		return $this->error;
	}

	public function getConfigurationPage() {
		return $this->configurationPage;
	}

	public function isDynamic() {
		return $this->isDynamic;
	}

	public function isLoaded() {
		return $this->loaded;
	}

	public function getContents() {
		return $this->contents;
	}

	public function edit() {
		if ($this->editing) {
			if ($this->isDynamic) {
				return 'Please edit this snippet using its <a href="' . ROOTURL . $this->configurationPage . '">configuration page</a>.';
			} else {
				$editor = '<form method="POST">' .
					CreateEditor($this->contents, 'snippetCode') .
	 				'<input type="submit" value="Save Changes">
	 			</form>';
				return $editor;
			}
		} else {
			return 'This snippet is not open for editing.';
		}
	}

	public function diagnose() {
		var_dump($this);
	}
}
?>