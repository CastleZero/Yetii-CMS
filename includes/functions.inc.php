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
* @version 1.0
* @var pageURL string The URL of the page to get
* @var parsed bool Whether or not the page should be parsed, or returned in its original form
* @return mixed
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
    // Get the page contents by first checking if the requested file is a file. If it is not, check if the file is in the database. If it is neither, return a 404 error.
    if (file_exists($pageURL) || file_exists($pageURL . '.php')) {
        $pageSavedIn = 'file';
        if (!file_exists($pageURL)) {
            $pageURL = $pageURL . '.php';
        }
        // File exists on the system, load it
        $pageContents = file_get_contents($pageURL);
        if (json_decode($pageContents) !== NULL) {
            // Page has variables to load
            if ($parsed) {
                $pageVariables = json_decode($pageContents, true);
                // Extract the page variables array into variables
                extract($pageVariables);
                // Get the page contents by using the page layout
                ob_start();
                include(PAGESFOLDER . $pageType . '/index.php');
                $pageContents = ob_get_clean();
            } else {
                $pageContents = json_decode($pageContents, true);
            }
        } else {
            // Page is simply a file to load
            if ($parsed) {
                ob_start();
                include($pageURL);
                $pageContents = ob_get_clean();
            } else {
                $pageContents = json_decode($pageContents);
            }
        }
    } else {
        // Check if the URL is available in the database
        $pageSavedIn = 'database';
        $mapper = new Mapper();
        if ($valuesArray = $mapper->GetPageContent($pageURL)) {
            // Page exists in the database
            // Extract the returned array into variables
            extract($valuesArray);
            // Decode the JSON encoded page variables
            $pageVariables = json_decode($pageVariables, true);
            // Extract the page variables array into variables
            extract($pageVariables);
            // Get the page contents by using the page layout
            if ($parsed) {
                ob_start();
                include(PAGESFOLDER . $pageType . '/index.php');
                $pageContents = ob_get_clean();
            } else {
                $pageContents = $pageVariables;
            }
        } else {
            $pageContents = false;
        }
        unset($mapper);
    }
    if (is_array($pageContents)) {
        $pageContents['pageSavedIn'] = $pageSavedIn;
    }
    return $pageContents;
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
* @version 1.0
* @return array 
*/
function GetSnippets() {
    $snippets = array();
    $directories = glob(SNIPPETSFOLDER . '*');
    foreach ($directories as $directory) {
        if (is_dir($directory)) {
            if (is_file($directory . '/index.php')) {
                $valid = true;
            } else {
                $valid = 'No index.php file found';
            }
            $name = str_replace(SNIPPETSFOLDER, '', $directory);
            $snippet = array('name' => $name, 'valid' => $valid);
            array_push($snippets, $snippet);
        }
    }
    return $snippets;
}

/**
* Checks if a snippet is valid, and then displays the snippet if it is
*
* @author Joseph Duffy
* @version 1.0
* @return string
*/

function GetSnippet($snippet) {
    $snippetLocation = SNIPPETSFOLDER . $snippet;
    if (is_dir($snippetLocation)) {
        // The snippets folder was provided, check for an index.php file
        if (is_file($snippetLocation . '/index.php')) {
            ob_start();
            include($snippetLocation . '/index.php');
            return ob_get_clean();
        } else {
            // No index.php is present, so the snippet is not valid
            return 'No index.php file was present; snippet cannot be loaded.<br>';
        }
    } else if (is_file($snippetLocation)) {
        ob_start();
        include($snippetLocation);
        return ob_get_clean();
    } else {
        // Supplied snippet was not valid
        return 'Snippet could not be found in the snippets folder.<br>';
    }
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
    include_once "/includes/ckeditor/ckeditor.php";
    // Create a class instance.
    $CKEditor = new CKEditor();
    // Path to the CKEditor directory, ideally use an absolute path instead of a relative dir.
    $CKEditor->basePath = '/includes/ckeditor/';
    // Create a textarea element and attach CKEditor to it.
    $CKEditor->editor($id, $contents);
}
?>