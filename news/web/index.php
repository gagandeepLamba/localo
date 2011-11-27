<?php

    include 'news-app.inc';
	include($_SERVER['APP_WEB_DIR'] . '/inc/header.inc');
	
    $postDao = new com\indigloo\news\dao\Post();
    $posts = $postDao->getRecords();
    
    foreach($posts as $post) {
        echo $post['title'];
    }


?>
