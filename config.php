<!DOCTYPE HTML>
<?php
    $db_exists = file_exists("/home/bb/Public/db/ichat.db");
    $db = new PDO('sqlite:host=/home/bb/Public/db/ichat.db');
      
?>
