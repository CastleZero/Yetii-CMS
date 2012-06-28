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
?>