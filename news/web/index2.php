<?php

    include 'news-app.inc';
	include($_SERVER['APP_WEB_DIR'] . '/inc/header.inc');
	
	use com\indigloo\Configuration as Config ;
	use com\indigloo\Logger  as Logger ;
	use com\indigloo\Util  as Util ;
	
	$start = NULL;
	$direction = NULL;
	
	if(array_key_exists('after',$_GET)) {
		$direction = 'after' ;
		$start = $_GET['after'] ;
	}
	
	if(array_key_exists('before',$_GET)) {
		$direction = 'before' ;
		$start = $_GET['before'] ;
	}
	
	$pageNo = $_GET['pageNo'];
	
	Util::isEmptyMessage('parameter start', $start);
	Util::isEmptyMessage('parameter direction', $direction);
	Util::isEmptyMessage('parameter pageNo', $pageNo);
	
	//convert back to base10
	$start = base_convert($start,36,10);
	
    $postDao = new \com\indigloo\news\dao\Post();
	$postDBRows = $postDao->getPostWithMedia($start,$direction);
	$totalPages = $postDao->getTotalPages();
	$paginator = new \com\indigloo\ui\Pagination($pageNo,$totalPages);
	
	$file = $_SERVER['APP_WEB_DIR']. '/view/home.php' ;
	ob_start();
	include ($file);
	$buffer = ob_get_contents();
	ob_end_clean();
	echo $buffer;

?>
