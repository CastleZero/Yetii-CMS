<?php

function ShowErrors($errors) {
    ?>
    <div id="errors">
        Errors<br>
        <ul>
            <?
            for ($i = 0; $i < count($errors); $i++) {
                if (isset($errors[$i]['fieldId'])) {
                    // Highlight the field
                    ?>
                    <script>
                        var cross = '<img src="images/cross.png">';
                        $(document).ready(function(){
                            $("#<?php echo $errors[$i]['fieldId']; ?>hint").html(cross);
                        });
                    </script>
                    <?
                }
                ?>
                <li>
                    <? echo $errors[$i]['message']; ?><br >
                </li>
                <?
            }
            ?>
        </ul>
    </div>
    <?
}

function UsersAuth() {
    if (isset($_SESSION['userId'])) {
        $mapper = new Mapper();
        return $mapper->GetUsersAuth($_SESSION['userId']);
    } else {
        return 0;
    }
}

/**
* 
*
* @author Joseph Duffy
* @version 1.1
* @var pageURL string The URL of the page to get
* @var parsed bool Whether or not the page should be parsed, or returned in its original form
* @return array
*/

function GetPage($pageURL, $parsed = true) {
    // Check if the requests file is a directory; if so, get the index file
    if (is_dir($pageURL)) {
        if (substr($pageURL, '-1') != '/') {
            // Add a "/" to the end of the directory name so we can look for the index file
            $pageURL .= '/';
        }
        $pageURL = $pageURL . 'index.php';
    } else if ($pageURL == '') {
        // We are at the root address
        $pageURL = 'index.php';
    }
    $pageVariables = array();
    // Get the page contents by first checking if the requested file is a file. If it is not, check if the file is in the database. If it is neither, return false
    if (file_exists($pageURL) || file_exists($pageURL . '.php')) {
        $pageSavedIn = 'file';
        if (!file_exists($pageURL)) {
            $pageURL = $pageURL . '.php';
        }
        // File exists on the system, load it
        $fileContents = file_get_contents($pageURL);
        if ($parsed) {
            ob_start();
            include($pageURL);
            $pageVariables['pageContents'] = ob_get_clean();
            if (isset($pageName)) {
                $pageVariables['pageName'] = $pageName;
            } else {
                $pageVariables['pageName'] = null;
            }
            if (isset($requiredAuth)) {
                $pageVariables['requiredAuth'] = $requiredAuth;
            } else {
                $pageVariables['requiredAuth'] = 0;
            }
            if (isset($useEngine)) {
                $pageVariables['useEngine'] = $useEngine;
            } else {
                $pageVariables['useEngine'] = true;
            }
        } else {
            $pageVariables['pageContents'] = $fileContents;
        }
    } else {
        $pageVariables = false;
    }
    return $pageVariables;
}

function write_ini_file($assoc_arr, $path, $has_sections=FALSE) { 
    $content = ""; 
    if ($has_sections) { 
        foreach ($assoc_arr as $key=>$elem) { 
            $content .= "[".$key."]\n\r"; 
            foreach ($elem as $key2=>$elem2) { 
                if(is_array($elem2)) 
                { 
                    for($i=0;$i<count($elem2);$i++) 
                    { 
                        $content .= $key2."[] = \"".$elem2[$i]."\"\n\r"; 
                    } 
                } 
                else if($elem2=="") $content .= $key2." = \n\r"; 
                else $content .= $key2." = \"".$elem2."\"\n\r"; 
            } 
        } 
    } else { 
        foreach ($assoc_arr as $key=>$elem) { 
            if(is_array($elem)) 
            { 
                for($i=0;$i<count($elem);$i++) 
                { 
                    $content .= $key."[] = \"".$elem[$i]."\"\n\r"; 
                } 
            } 
            else if($elem=="") $content .= $key." = \n\r"; 
            else $content .= $key." = \"".$elem."\"\n\r"; 
        } 
    } 

    if (!$handle = fopen($path, 'w')) { 
        return false; 
    } 
    if (!fwrite($handle, $content)) { 
        return false; 
    } 
    fclose($handle); 
    return true; 
}

/**
* Get all the available snippets in the snippets folder and returns them. It also checks if a snippet is valid
*
* @author Joseph Duffy
* @version 1.1
* @return array 
*/
function GetSnippets() {
    $snippets = array();
    $directories = glob(SNIPPETSFOLDER . '*');
    foreach ($directories as $directory) {
        if (is_dir($directory)) {
            $baseName = str_replace(SNIPPETSFOLDER, '', $directory);
            if (is_file($directory . '/variables.ini')) {
                if (is_file($directory .  '/index.php')) {
                    $files = glob($directory . '/*.ini');
                    foreach ($files as $file) {
                        $fileName = str_replace($directory, '', $file);
                        if ($fileName == '/index.ini' || $fileName == '/variables.ini') {
                            $name = $baseName;
                        } else {
                            $name = $baseName . $fileName;
                        }
                        if (count($files) > 1) {
                            if ($fileName != '/variables.ini') {
                                $snippet = array('name' => $name, 'valid' => true, 'dynamic' => true);
                                array_push($snippets, $snippet);
                            }
                        } else {
                            // Only 1 ini file exists, so the snippet it invalid
                            $snippet = array('name' => $name, 'valid' => 'No custom pages exists.', 'dynamic' => true);
                            array_push($snippets, $snippet);
                        }
                    }
                } else {
                    $valid = 'A variables.ini file was present but no index.php was present.';
                    $snippet = array('name' => $name, 'valid' => $valid, 'dynamic' => true);
                    array_push($snippets, $snippet);
                }
            } else {
                $files = glob($directory . '/*.php');
                foreach ($files as $file) {
                    $fileName = str_replace($directory, '', $file);
                    if ($fileName == '/index.php') {
                        $name = $baseName;
                    } else {
                        $name = $baseName . $fileName;
                    }
                    $snippet = array('name' => $name, 'valid' => true, 'dynamic' => false);
                    array_push($snippets, $snippet);
                }
            }
        }
    }
    return $snippets;
}

/**
* Checks if a snippet is valid, and then displays the snippet if it is
*
* @author Joseph Duffy
* @version 1.1.1
* @return string
*/

function GetSnippet($snippet, $parsed = true) {
    $snippetLocation = SNIPPETSFOLDER . $snippet;
    if (is_dir($snippetLocation)) {
        // The snippets folder was provided, check for an index file
        if (is_file($snippetLocation . '/index.php')) {
            // An index file was provided
            if (is_file($snippetLocation . '/variables.ini')) {
                // Snippet is dynamic
                $snippetConfigFile = $snippetLocation . '/variables.ini';
                if (is_file($snippetLocation . '/index.ini')) {
                    // Default ini has been created
                    $snippetVariablesFile = $snippetLocation . '/index.ini';
                    $snippetVariables = parse_ini_file($snippetVariablesFile, true);
                    $snippetFile = $snippetLocation . '/index.php';
                } else {
                    // No index.ini file was found, check for it in the database
                    echo $snippet . ' is a dynamic snippet but no index.ini file was found.';
                    return false;
                }
            } else {
                // Snippet is static
                if (is_file($snippetLocation . '/index.php')) {
                    $snippetFile = $snippetLocation . '/index.php';
                } else {
                    // No index.php file was found, check for it in the database
                    echo $snippet . '\'s directory was provided but no index.php file was found.';
                    return false;
                }
            }
        } else {
            // No index.php is present, so the snippet is not valid
            return 'No index.php file was present; snippet cannot be loaded.<br>';
        }
    } else if (is_file($snippetLocation)) {
        // Snippet provided is a file
        $snippetFile = $snippetLocation;
    } else {
        // Supplied snippet was not valid
        echo '"' . $snippet . '" could not be found in the snippets folder.<br>';
        return false;
    }
    if ($parsed) {
        if (isset($snippetVariablesFile)) {
            extract($snippetVariables);
        }
        ob_start();
        include($snippetFile);
        $snippet = ob_get_clean();
    } else {
        // Not parsing the snippet
        $snippet = array();
        if (isset($snippetVariables)) {
            // Returning a dynamic snippet
            $snippet['location'] = $snippetVariablesFile;
            $snippet['code'] = $snippetVariables;
            $snippet['type'] = 'dynamic';
            $snippet['configFile'] = $snippetConfigFile;
        } else {
            // Returning a static snippet
            $snippet['location'] = $snippetFile;
            $snippet['code'] = file_get_contents($snippetFile);
            $snippet['type'] = 'static';
        }
    }
    return $snippet;
}

/**
* This is pretty much identical to GetSnippets(), but it differs in that it also checks if a variables.ini file exists
*
* @author Joseph Duffy
* @version 1.0
* @return array
*/

function GetPageTypes() {
    $pages = array();
    $directories = glob(PAGESFOLDER . '*');
    foreach ($directories as $directory) {
        if (is_dir($directory)) {
            if (is_file($directory . '/index.php')) {
                if (is_file($directory . '/variables.ini')) {
                    $valid = true;
                } else {
                    $valid = 'No variables.ini file found.';
                }
            } else {
                $valid = 'No index.php file found.';
            }
            $name = str_replace(PAGESFOLDER, '', $directory);
            $page = array('pageType' => $name, 'valid' => $valid);
            array_push($pages, $page);
        }
    }
    return $pages;
}

/**
* Checks if a page type is valid. If it is not valid it returns the error. If it is valid, it returns true
* @author Joseph Duffy
* @version 1.0
* @return mixed
*/

function IsValidPageType($pageType) {
    return false;
}

function Move($old, $new, $delete = false) {
    $errors = array();
    if (is_dir($old)) {
        // Object to be moved is a directory, move all the files in that directory
        if ($directory = opendir($old)) {
            while (($file = readdir($directory)) !== false) {
                if ($file != "." && $file != "..") {
                    $fileInfo = pathinfo($file);
                    if (array_key_exists('extension', $fileInfo)) {
                        // Object is a file
                        $fileName = $fileInfo['filename'];
                        $fileExtension = $fileInfo['extension'];
                        $fullFileName = $fileInfo['basename'];
                        Move($old . '/' . $fullFileName, $new . '/' . $fullFileName);
                    } else {
                        // Object is a directory
                        $directoryName = $fileInfo['basename'];
                        // If the directory does not yet exists at the new location, create it
                        if (!is_dir($new . '/' . $directoryName)) {
                            mkdir($new . '/' . $directoryName);
                        }
                        // Move all the files in the directory
                        Move($old . $directoryName, $new . '/' . $directoryName);
                    }
                }
            }
            closedir($directory);
        }
    } else if (is_file($old)) {
        // Object to be moved is a file
        //echo 'Copying "' . $old . '" to "' . $new . '"<br>';
        if (!copy($old, $new)) {
            $error = array('message' => 'There was an error moving "' . $old . '" to "' . $new .'". This may cause the template to not function correctly, and should be looked into.');
            array_push($errors, $error);
            return $errors;
        } else {
            return true;
        }
    } else {
        // $error = array('message' => $old . ' is not a file or a directory, please check your value.');
        // array_push($errors, $error);
        echo $old . ' is not a file or a directory, please check your value.<br>';
    }
    if ($delete) {
        if (DeleteDirectory($old)) {
            return true;
        } else {
            return false;
        }
    } else {
       return true;
    }
}

function DeleteDirectory($directory) {
    return false;
}

function CreateEditor($contents, $id = 'codeTextbox') {
    // Include the CKEditor class.
    include_once "ckeditor/ckeditor.php";
    // Create a class instance.
    $CKEditor = new CKEditor();
    // Path to the CKEditor directory, ideally use an absolute path instead of a relative dir.
    $CKEditor->basePath = '/includes/ckeditor/';
    // Create a textarea element and attach CKEditor to it.
    $CKEditor->editor($id, $contents);
}
?>