<?php

    include 'news-app.inc';
	include($_SERVER['APP_WEB_DIR'] . '/inc/header.inc');
	
    $postDao = new com\indigloo\news\dao\Post();
    $posts = $postDao->getRecords();
    
    foreach($posts as $post) {
        echo $post['title'];
    }
    
    $router = new com\indigloo\news\Router();
    //initialize news app routing table
    $router->initTable();
    $route = $router->getRoute($_SERVER['REQUEST_URI']);
    
    if(is_null($route))
        echo " Null route" ;
        
    print_r($route);



?>
