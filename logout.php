<?php
	require_once 'includes/Twig/Autoloader.php';
    require_once "config.php";
	session_start();

    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }
    session_destroy();

    $stmt = $db->prepare("SELECT * FROM zarlal");
    $stmt->execute();
    $result = $stmt->fetchAll();
    class Event {}
    $events = array();
    foreach($result as $row) {
        $e = new Event();
        $e->id = $row['id'];
        $e->topic = $row['topic'];
        $e->logged = $row['logged'];
        $e->chatter = $row['chatter'];
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
    
    echo $template->render(array('title' => 'iChat','categories'=>$categories,'zars'=>$events,'num' =>$num, 'user'=>null));
    

?>