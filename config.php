<!DOCTYPE HTML>
<?php
    $db_exists = file_exists("/opt/lampp/htdocs/icharmn-web/ichat.db");
    $db = new PDO('sqlite:/opt/lampp/htdocs/ichatmn-web/ichat.db');
      
?>
