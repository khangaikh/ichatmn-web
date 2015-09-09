<?php
    require_once "config.php";
 
    //$_SESSION = "Array ( [parseData] => Array ( [user] => Parse\ParseUser [_sessionToken:protected] => r:LAy74EsFuobzvlAQgmRdF00LV [serverData:protected] => Array ( [username] => admin ) [operationSet:protected] => Array ( ) [estimatedData:Parse\ParseObject:private] => Array ( [username] => admin ) [dataAvailability:Parse\ParseObject:private] => Array ( [sessionToken] => 1 [username] => 1 ) [className:Parse\ParseObject:private] => _User [objectId:Parse\ParseObject:private] => D6C1mdK86t [createdAt:Parse\ParseObject:private] => DateTime Object ( [date] => 2015-08-28 18:56:27.592000 [timezone_type] => 2 [timezone] => Z ) [updatedAt:Parse\ParseObject:private] => DateTime Object ( [date] => 2015-08-28 18:56:27.592000 [timezone_type] => 2 [timezone] => Z ) [hasBeenFetched:Parse\ParseObject:private] => 1 ) ) [count] => 1 ) ";

    //$new = $_POST['loan'];
    $url ="";
    
    if (!file_exists("upload"))
    {
       mkdir("upload", 0777, true);
    }
    if (file_exists("upload/" . $_FILES["import"]["name"]))
    {
        echo $_FILES["import"]["name"] . " already exists. ";
    }
    else
    {
        move_uploaded_file($_FILES["import"]["tmp_name"],
        "upload/" . $_FILES["import"]["name"]);
        $url = "upload/" . $_FILES["import"]["name"];
        //echo "Stored in: " . "upload/" . $_FILES["import"]["name"];
    }
    
    class Result {}
    $response = new Result();
    date_default_timezone_set('Asia/Ulaanbaatar');
    $date = date('Y-m-d H:i', time());
    //$date = null;
    try {
        $stmt = $db->prepare("INSERT INTO zarlal (topic, start, end, category, desc_more, status, location, image) VALUES (:topic, :start, :end, :category, :desc_more, :status, :location, :image)");
        
        $stmt->bindParam(':topic', $_POST['name']);
        $stmt->bindParam(':start', $_POST['start']);
        $stmt->bindParam(':end', $_POST['end']);
        $stmt->bindParam(':category', $_POST['category']);
        $stmt->bindParam(':desc_more', $_POST['desc_more']);
        $stmt->bindParam(':image', $url);
        $stmt->bindParam(':location', $_POST['location']);
        $stmt->execute();
       
    }
    catch( PDOException $Exception ) {
        // PHP Fatal Error. Second Argument Has To Be An Integer, But PDOException::getCode Returns A
        // String.
        $response->message = $Exception->getCode( );
    }

    $response->result = 'OK';
    $response->id = $db->lastInsertId();

    header('Content-Type: application/json');
    echo json_encode($response);
?>