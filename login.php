<?php
    require_once "config.php";

    /* Kerberos authentication */
    /* 
    $handle = kadm5_init_with_password("afs-1", "ICHAT.MN", "admin/admin", $_POST['password']);

    $attributes = KRB5_KDB_REQUIRES_PRE_AUTH | KRB5_KDB_DISALLOW_PROXIABLE;
    $options = array(KADM5_PRINC_EXPIRE_TIME => 0,
                     KADM5_POLICY => "default",
                     KADM5_ATTRIBUTES => $attributes);

    $options = kadm5_get_principal($handle, "bulgaa@ICHAT.MN" );

    foreach ($options as $key => $value) {
            echo "$key: $value<br />\n";
    } */

    class Result {}
    $response = new Result();
    //$date = null;
    try {
        $stmt = $db->prepare("SELECT * FROM users WHERE username=:username AND pass=:password");
        $stmt->bindParam(':username', $_POST['email']);
        $stmt->bindParam(':password', $_POST['password']);
        $stmt->execute();
        $results = $stmt->fetchAll();
    }
    catch( PDOException $Exception ) {
        // PHP Fatal Error. Second Argument Has To Be An Integer, But PDOException::getCode Returns A
        // String.
        $response = $Exception->getCode( );
    }
    if(count($results)>0){
        session_start();
        $_SESSION['user'] = $_POST['email'];
        //$_SESSION['secret'] = $encrypted;
        $response->message = 1;
    }else{
        $response->message = 0;
    }
    
    echo json_encode($response); 
?>