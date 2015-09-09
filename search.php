<?php
	require_once 'includes/Twig/Autoloader.php';
    require_once "config.php";
 
    //$_SESSION = "Array ( [parseData] => Array ( [user] => Parse\ParseUser [_sessionToken:protected] => r:LAy74EsFuobzvlAQgmRdF00LV [serverData:protected] => Array ( [username] => admin ) [operationSet:protected] => Array ( ) [estimatedData:Parse\ParseObject:private] => Array ( [username] => admin ) [dataAvailability:Parse\ParseObject:private] => Array ( [sessionToken] => 1 [username] => 1 ) [className:Parse\ParseObject:private] => _User [objectId:Parse\ParseObject:private] => D6C1mdK86t [createdAt:Parse\ParseObject:private] => DateTime Object ( [date] => 2015-08-28 18:56:27.592000 [timezone_type] => 2 [timezone] => Z ) [updatedAt:Parse\ParseObject:private] => DateTime Object ( [date] => 2015-08-28 18:56:27.592000 [timezone_type] => 2 [timezone] => Z ) [hasBeenFetched:Parse\ParseObject:private] => 1 ) ) [count] => 1 ) ";

    //$new = $_POST['loan'];
    $search = $_POST['data'];
    $stmt_string = "SELECT * FROM zarlal WHERE category = ";

    class Event {}

    $events = array();

    for($i=0; $i<count($search);$i++){
        if($search[$i]!=1 || $search[$i]!=2 || $search[$i]!=3 || $search[$i]!=4 ){
            try {
                $stmt_string = 'SELECT * FROM zarlal WHERE category = ';
                $stmt = $db->prepare("SELECT * FROM zarlal WHERE category = :category");
                $stmt->bindParam(':category', $search[$i]);
                $stmt->execute();
                $results = $stmt->fetchAll();
                
            }
            catch( PDOException $Exception ) {
                $response->message = $Exception->getCode( );
            }
            foreach ($results as $row) {
                $e = new Event();
                $e->id = $row['ID'];
                $e->topic = $row['topic'];
                $e->date = $row['start'];
                $e->category = $row['category'];
                $e->location = $row['location'];
                $e->status = $row['status'];
                $e->image = $row['image'];
                $e->desc_more = $row['desc_more'];
                $events[] = $e; 
            }
            
            
        }
        
    } 
    //$response->id = $db->lastInsertId();
    header('Content-Type: application/json');
    echo json_encode($events);
?>