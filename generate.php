<?php
  	require_once "key.php";
  	require_once "config.php";

  	$chatid = $_POST['cid'];
  	$chattopic = $_POST['topic'];
  	$username = $_POST['user'];

  	date_default_timezone_set('Asia/Ulaanbaatar');
    $date = date('Y-m-d H:i', time());

  	$string = $chatid.$username.$date;
	  $pass =  passwordGenerate();
	  $method = 'aes256';
    /* Encryption with open ssl creating key*/
	 file_put_contents ('./file.encrypted', openssl_encrypt ($string, $method, $pass));
	 $encrypted = openssl_encrypt ($string, $method, $pass);

	try {
        $stmt = $db->prepare("INSERT INTO chat (chat_key, topic) VALUES (:chat_key, :topic)");
        $stmt->bindParam(':chat_key', $chatid);
        $stmt->bindParam(':topic', $chattopic);
        $stmt->execute();
       
    }
    catch( PDOException $Exception ) {
        // PHP Fatal Error. Second Argument Has To Be An Integer, But PDOException::getCode Returns A
        // String.
        //echo($Exception->getCode());
        echo 0;
    }
    $chat=$db->lastInsertId();

    try {
        $stmt = $db->prepare("INSERT INTO chat_user (chat_id, user_id, pass, key) VALUES (:chat_id, :user_id, :pass, :key)");
        
        $stmt->bindParam(':chat_id', $chat);
        $stmt->bindParam(':user_id', $username);
        $stmt->bindParam(':pass', $pass);
        $stmt->bindParam(':key', $encrypted);
        $stmt->execute();
       
    }
    catch( PDOException $Exception ) {
        // PHP Fatal Error. Second Argument Has To Be An Integer, But PDOException::getCode Returns A
        // String.
        //echo($Exception->getCode());
        echo 0;
    }

    echo json_encode($pass);

?>