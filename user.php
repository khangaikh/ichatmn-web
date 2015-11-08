<?php
    require_once "config.php";
 
    //$date = null;
    $email =  $_POST['email'];
    $pass = $_POST['password'];
    $user = $_POST['username'];

    try {
        $stmt = $db->prepare("INSERT INTO users (username, email, pass) VALUES (:username, :email, :password)");
        $stmt->bindParam(':username',$user);
        $stmt->bindParam(':email',$email);
        $stmt->bindParam(':password',$pass);
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