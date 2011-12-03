<?php
    
    include 'news-app.inc';
	include($_SERVER['APP_WEB_DIR'] . '/inc/header.inc');
    include($_SERVER['APP_WEB_DIR'] . '/inc/staff-role.inc');
	
    use com\indigloo\Util as Util ;
    use com\indigloo\news\Url as Url ;
    
    
    $postId = $_GET['g_post_id'];
    Util::isEmpty('g_post_id',$postId);
    
	$mediaId = $_GET['g_id'];
    Util::isEmpty('g_id',$mediaId);
    
	
    $mediaDao = new \com\indigloo\news\dao\Media();
    $mediaDao->deleteOnId($mediaId);
	
	$location = Url::base().'/post/edit-media.php?g_post_id='.$postId ;
	header("location: " . $location);
	
?>