<?php
    require_once 'includes/Twig/Autoloader.php';
    require_once "config.php";
        
    $stmt = $db->prepare("SELECT * FROM zarlal");
    $stmt->execute();
    $result = $stmt->fetchAll();

    class Event {}
    $events = array();

    foreach($result as $row) {
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
    $template = $twig->loadTemplate('index.html');
    $user = null;

    $num = count($events);

    if($_GET){
        if($_GET['cid']==0){
            $template = $twig->loadTemplate('login.html');
            echo $template->render(array('title' => 'iChat-Login'));
        }
    }else{
        if($_SESSION){
            if($_SESSION['user']){
                $user = $_SESSION['user'];

                echo $template->render(array('title' => 'iChat','categories'=>$categories,'zars'=>$events,'num' =>$num, 'user'=>$user));
            }else{
                $template = $twig->loadTemplate('login.html');
                echo $template->render(array('title' => 'iChat-Login'));}
        }
        else{
            echo $template->render(array('title' => 'iChat','categories'=>$categories,'zars'=>$events,'num' =>$num, 'user'=>null));
        }
    }
?>
