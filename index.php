<?php
    require_once 'includes/Twig/Autoloader.php';
    require_once "config.php";
    
    session_start();

    $stmt = $db->prepare("SELECT * FROM zarlal");
    $stmt->execute();
    $result = $stmt->fetchAll();
    class Event {}
    $events = array();
    foreach($result as $row) {
        $e = new Event();
        $e->id = $row['id'];
        $e->logged = $row['logged'];
        $e->chatter = $row['chatter'];
        $e->topic = $row['topic'];
        $e->date = $row['start'];
        $e->category = $row['category'];
        $e->location = $row['location'];
        $e->status = $row['status'];
        $e->image = $row['image'];
        $e->desc_more = $row['desc_more'];
        $e->user= $row['user'];
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
    
   

    if(isset($_SESSION['user'])){
        $user =$_SESSION['user'];
        if(isset($_GET['logout'])){
            session_unset();
            session_destroy();  
            echo $template->render(array('title' => 'iChat','categories'=>$categories,'zars'=>$events,'num' =>$num, 'user'=>null));
        }else if(isset($_GET['detail'])){
            $template = $twig->loadTemplate('detail.html');
            $stmt = $db->prepare("SELECT * FROM zarlal WHERE id=:id");
            $stmt->bindParam(':id',$_GET['detail']);
            $stmt->execute();
            $zar = $stmt->fetch(PDO::FETCH_ASSOC);

            $stmt = $db->prepare("SELECT * FROM comments WHERE zarlalId=:id");
            $stmt->bindParam(':id',$_GET['detail']);
            $stmt->execute();
            $comments = $stmt->fetchAll();
            echo $template->render(array('title' => 'iChat-detail', 'zar' => $zar, 'comments' =>$comments,'user'=>$user));
        }
        else{
            echo $template->render(array('title' => 'iChat','categories'=>$categories,'zars'=>$events,'num' =>$num, 'user'=>$user));
        }
    }
    else{
        if(isset($_GET['detail'])){
            $template = $twig->loadTemplate('detail.html');
            $stmt = $db->prepare("SELECT * FROM zarlal WHERE id=:id");
            $stmt->bindParam(':id',$_GET['detail']);
            $stmt->execute();
            $zar = $stmt->fetch(PDO::FETCH_ASSOC);
            $stmt = $db->prepare("SELECT * FROM comments WHERE zarlalId=:id");
            $stmt->bindParam(':id',$_GET['detail']);
            $stmt->execute();
            $comments = $stmt->fetchAll();
            echo $template->render(array('title' => 'iChat-detail', 'zar' => $zar, 'comments' =>$comments));
        }else if(isset($_GET['login'])){
            $template = $twig->loadTemplate('login.html');
             echo $template->render(array('title' => 'iChat-detail'));
        }
        else{
            echo $template->render(array('title' => 'iChat','categories'=>$categories,'zars'=>$events,'num' =>$num, 'user'=>null));
        }
       
    }
    
?>