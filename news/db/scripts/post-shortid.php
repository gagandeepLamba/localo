<?php
    include('news-app.inc');
    include($_SERVER['APP_CLASS_LOADER']);

    use \com\indigloo\mysql as MySQL;
    use \com\indigloo\Util as Util ;
    use \com\indigloo\seo\StringUtil as SeoStringUtil ;
    
    
    $sql = " select id,title from news_post ";
    $mysqli = MySQL\Connection::getInstance()->getHandle();
    $rows = MySQL\Helper::fetchRows($mysqli, $sql);
    
    
    
    foreach($rows as $row) {
        
        $updateSQL = " update news_post set seo_title = ? , short_id = ? where id = ? " ;
        $stmt = $mysqli->prepare($updateSQL);
        
        $seoTitle = SeoStringUtil::convertNameToSeoKey($row['title']) ;
        $shortId = Util::getRandomString(8);
        $rowId = $row['id'];
        
        printf("Short Id = %s, SEO title = %s \n", $shortId,$seoTitle );
        
        if ($stmt) {
            $stmt->bind_param("ssi",$seoTitle,$shortId,$rowId) ;
            $stmt->execute();
            $stmt->close();
            
        } else {
            trigger_error("mysql error",E_USER_ERROR) ;
        }
      
    }
    
?>