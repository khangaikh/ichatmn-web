<?php
    require_once "config.php";
    require_once 'includes/Twig/Autoloader.php';
    session_start();
    
    if(isset($_SESSION)){
        if(isset($_SESSION['user'])){

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
                echo "Stored in: " . "upload/" . $_FILES["import"]["name"];
            }
            
            class Result {}
            $response = new Result();
            date_default_timezone_set('Asia/Ulaanbaatar');
            $date = date('Y-m-d H:i', time());
            //$date = null;
            try {
                $stmt = $db->prepare("INSERT INTO zarlal (topic, start, end, category, desc_more, status, location, image, logged, user) VALUES (:topic, :start, :end, :category, :desc_more, :status, :location, :image, :logged, :user)");
                
                $stmt->bindParam(':topic', $_POST['name']);
                $stmt->bindParam(':start', $_POST['start']);
                $stmt->bindParam(':end', $_POST['end']);
                $stmt->bindParam(':category', $_POST['category']);
                $stmt->bindParam(':desc_more', $_POST['desc_more']);
                $stmt->bindParam(':image', $url);
                $stmt->bindParam(':location', $_POST['location']);
                $stmt->bindParam(':location', $_POST['location']);
                $stmt->bindValue(':logged', 0);
                $stmt->bindValue(':user', $_SESSION['user']);
                $stmt->execute();
               
            }
            catch( PDOException $Exception ) {
                // PHP Fatal Error. Second Argument Has To Be An Integer, But PDOException::getCode Returns A
                // String.
                $response->message = $Exception->getCode( );
                echo $Exception->getCode( );
            }

            $response->result = 'OK';
            $response->id = $db->lastInsertId();

            //header('Content-Type: application/json');
            //echo json_encode($response);
            
            $stmt = $db->prepare("SELECT * FROM zarlal");
            $stmt->execute();
            $result = $stmt->fetchAll();

            class Event {}
            $events = array();

            foreach($result as $row) {
                $e = new Event();
                $e->id = $row['id'];
                $e->topic = $row['topic'];
                $e->date = $row['start'];
                $e->category = $row['category'];
                $e->location = $row['location'];
                $e->status = $row['status'];
                $e->image = $row['image'];
                $e->desc_more = $row['desc_more'];
                $e->user = $row['user'];
                $events[] = $e;
            }

            $stmt = $db->prepare("SELECT * FROM category");
            $stmt->execute();
            $result = $stmt->fetchAll();

            class Cate {}
            $categories = array();

            foreach($result as $row) {
                $e = new Cate();
                $e->id = $row['ID'];
                $e->name = $row['name'];
                $categories[] = $e;
            }
            //register autoloader
            Twig_Autoloader::register();
            //loader for template files
            $loader = new Twig_Loader_Filesystem('templates');
            //twig instance
            $twig = new Twig_Environment($loader, array(
                'cache' => 'cache',
            ));
            //load template file
            $twig->setCache(false);
            $template = $twig->loadTemplate('main.html');
            $user = null;

            $num = count($events);
            $user = $_SESSION['user'];
            echo $template->render(array('title' => 'iChat','categories'=>$categories,'zars'=>$events,'num' =>$num, 'user'=>$user));
        }else if(isset($_GET['login'])){
            $template = $twig->loadTemplate('login.html');
            echo $template->render(array('title' => 'iChat-Login'));
        }
        else{
            echo $template->render(array('title' => 'iChat','categories'=>$categories,'zars'=>$events,'num' =>$num, 'user'=>null));
        }
    }
    else{
        echo $template->render(array('title' => 'iChat','categories'=>$categories,'zars'=>$events,'num' =>$num, 'user'=>null));
    }
    
?>
