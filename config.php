<!DOCTYPE HTML>
<?php
    $db_exists = file_exists("/home/bb/Public/db/ichat.db");
    $db = new PDO('/home/bb/Public/db/sqlite:ichat.db');
      
?>
