<!DOCTYPE HTML>
<?php
    $db_exists = file_exists("/home/bb/Public/db/ichat.db");
    $db = new PDO('sqlite:/home/bb/Public/db/ichat.db');
      
?>
