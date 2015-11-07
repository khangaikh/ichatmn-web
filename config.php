<!DOCTYPE HTML>
<?php
    $db_exists = file_exists("ichat.sqlite");
    $db = new PDO('sqlite:ichat.sqlite');
      
?>
