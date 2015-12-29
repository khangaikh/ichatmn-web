<?php
	require_once 'includes/Twig/Autoloader.php';
    require_once "config.php";

    $cid = $_POST['data'];
    
    session_start();

  
    date_default_timezone_set('Asia/Ulaanbaatar');
    $date = date('Y-m-d H:i', time());
    $user = $_SESSION['user'];
    //$date = null;
    try {
        $stmt = $db->prepare("INSERT INTO comments (comment, dateInserted, person, zarlalId) VALUES (:comment, :dateInserted, :person, :zarlalId)");
        
        $stmt->bindParam(':comment', $_POST['comment']);
        $stmt->bindParam(':dateInserted', $date);
        $stmt->bindParam(':person', $user);
        $stmt->bindParam(':zarlalId', $cid);
        $stmt->execute();
       
    }
    catch( PDOException $Exception ) {
        // PHP Fatal Error. Second Argument Has To Be An Integer, But PDOException::getCode Returns A
        // String.
        $response->message = $Exception->getCode( );
        echo $Exception->getCode( );
    }
   

    class Event {}
    
    $e = new Event();
    $e->id =$db->lastInsertId();
    $e->comment = $_POST['comment'];
	$e->date = $date;
    $e->user = $user;

    //$response->userid = $db->lastInsertId();
    header('Content-Type: application/json');
    echo json_encode($e);
?>