<?php
    require_once "config.php";

    $myfile = fopen("newfile.txt", "w") or die("Unable to open file!");
    $txt = json_encode(value)$_POST);
    fwrite($myfile, $txt);
    fclose($myfile);
    
?>
