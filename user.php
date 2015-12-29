<?php
    require_once "config.php";
 
    //$date = null;
    $email =  $_POST['email'];
    $pass = $_POST['password'];
    $user = $_POST['username'];

    $data ='{ "action": "get_key", "email": "'.$_POST['email'].'", "password": "'.$pass.'"}';
    //$data ='{ "action": "get_object_status", "userID": "2d07790a-1c45-4009-bf0a-00225b026576-274058952784174488076957492133-1448764851", "contentID": "'.$_POST['data'].'" }';

    $data_string = json_encode($data);
    $ch = curl_init('http://localhost/key_distribution/process.php');                                                                      
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                                                                          
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                                                                                                                                                           
    $res = curl_exec($ch);
    $pieces = explode("-----", $res);

    try {
        $stmt = $db->prepare("INSERT INTO users (username, email, pass, key ) VALUES (:username, :email, :password, :key)");
        $stmt->bindParam(':username',$user);
        $stmt->bindParam(':email',$email);
        $stmt->bindParam(':password',$pass);
        $stmt->bindParam(':key',$pieces[2]);
        $stmt->execute();
    }
    catch( PDOException $Exception ) {
        // PHP Fatal Error. Second Argument Has To Be An Integer, But PDOException::getCode Returns A
        // String.
        $response->message = $Exception->getCode( );
    }
    session_start();
    $_SESSION['user'] = $_POST['email'];
    $response= $pieces[2];
    echo $response;
?>