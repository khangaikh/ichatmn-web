<?php
    require_once "config.php";
 
    //$date = null;
    $pass = $_POST['password'];
    $user = $_POST['username'];

    try {
        $stmt = $db->prepare("SELECT * from users WHERE username=:username");
        $stmt->bindParam(':username',$user);
        $stmt->execute();
        $results = $stmt->fetchAll();
        if(count($results)>0){
            echo 3;
            return;
        }
    }
    catch( PDOException $Exception ) {
        echo $Exception->getCode( );
    }


    try {
        $stmt = $db->prepare("INSERT INTO users (username, pass ) VALUES (:username, :password)");
        $stmt->bindParam(':username',$user);
        $stmt->bindParam(':password',$pass);
        $stmt->execute();
    }
    catch( PDOException $Exception ) {
        echo $Exception->getCode( );
    }
    session_start();
    $_SESSION['user'] = $_POST['username'];
    echo 1;
?>