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
?>