<?php
    include('news-app.inc');
    include($_SERVER['APP_CLASS_LOADER']);
	include($_SERVER['WEBGLOO_LIB_ROOT'] . '/com/indigloo/error.inc');

    use \com\indigloo\mysql as MySQL;
    use \com\indigloo\Util as Util ;
    use \com\indigloo\seo\StringUtil as SeoStringUtil ;
    
    
    $sql = " select id from news_post ";
    $mysqli = MySQL\Connection::getInstance()->getHandle();
    $postRows = MySQL\Helper::fetchRows($mysqli, $sql);

    //print_r($postIds); 
    //exit ;
    
    foreach($postRows as $postRow) {
	$postId = $postRow['id'];
        //find media rows for this postId
        $mediaSQL = " select * from news_media where post_id = ".$postId ;
        $updateSQL = " update news_post set images_json = ? , links_json = ?  where id = ? ";
        $imageRows = MySQL\Helper::fetchRows($mysqli, $mediaSQL);
        $images = array();
	$links = array();
        
        foreach($imageRows as $imageRow){
            $mediaVO = \com\indigloo\news\view\Media::create($imageRow);
            array_push($images,$mediaVO);
        }
        
        $imageJson = json_encode($images);
        $linkJson = json_encode($links);
        //printf(" post id %d , images_json = %s \n\n",$postId,$json) ;
        
        
        $stmt = $mysqli->prepare($updateSQL);
        
        if ($stmt) {
            $stmt->bind_param("ssi",$imageJson,$linkJson,$postId) ;
            $stmt->execute();
            $stmt->close();
            
        } else {
            trigger_error($mysqli->error,E_USER_ERROR) ;
        } 
        
    }
    
?>
