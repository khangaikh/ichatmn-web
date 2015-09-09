<?php
    require_once "config.php";
 
    //$date = null;
    try {
        $stmt = $db->prepare("INSERT INTO users (username, email, password) VALUES (:username, :email, :password");
        
        $stmt->bindParam(':username', $_POST['username']);
        $stmt->bindParam(':email', $_POST['email']);
        $stmt->bindParam(':password', $_POST['password']);
        $stmt->execute();
       
    }
    catch( PDOException $Exception ) {
        // PHP Fatal Error. Second Argument Has To Be An Integer, But PDOException::getCode Returns A
        // String.
        $response->message = $Exception->getCode( );
    }
    session_start();
    $_SESSION['user'] = $_POST['email'];
    $response= $db->lastInsertId();
    echo $response;
?>