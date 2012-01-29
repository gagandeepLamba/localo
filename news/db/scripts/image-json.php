<?php
    include('news-app.inc');
    include($_SERVER['APP_CLASS_LOADER']);

    use \com\indigloo\mysql as MySQL;
    use \com\indigloo\Util as Util ;
    use \com\indigloo\seo\StringUtil as SeoStringUtil ;
    
    
    $sql = " select id from news_post ";
    $mysqli = MySQL\Connection::getInstance()->getHandle();
    $postIds = MySQL\Helper::fetchRows($mysqli, $sql);
    
    foreach($postIds as $postId) {
        //find media rows for this postId
        $mediaSQL = " select * from news_media where post_id = ".$postId ;
        $updateSQL = " update news_post set images_json = ? where id = ? ";
        $imageRows = MySQL\Helper::fetchRows($mysqli, $mediaSQL);
        $images = array();
        
        foreach($imageRows as $imageRow){
            $mediaVO = \com\indigloo\news\view\Media::create($imageRow);
            array_push($images,$mediaVO);
        }
        
        $json = json_encode($images);
        printf(" post id %d , images_json = %s \n\n",$postid,$json) ;
        
        /*
        $stmt = $mysqli->prepare($updateSQL);
        
        if ($stmt) {
            $stmt->bind_param("si",$json,$postId) ;
            $stmt->execute();
            $stmt->close();
            
        } else {
            trigger_error("mysql error",E_USER_ERROR) ;
        } */
        
    }
    
?>
