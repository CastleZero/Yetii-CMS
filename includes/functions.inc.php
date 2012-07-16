<?php

function ShowErrors($errors) {
    ?>
    <div id="errors">
        Errors<br>
        <ul>
            <?
            for ($i = 0; $i < count($errors); $i++) {
                if (isset($errors[$i]['name'])) {
                    // Highlight the field
                    ?>
                    <script>
                        var cross = '<img src="images/cross.png">';
                        $(document).ready(function(){
                            $('#<? echo $errors[$i]['name']; ?>hint').html(cross);
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
?>