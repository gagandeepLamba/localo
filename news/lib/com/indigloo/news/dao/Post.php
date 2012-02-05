<?php

namespace com\indigloo\news\dao {

    
    use \com\indigloo\Util as Util ;
    use \com\indigloo\news\mysql as mysql;
    use \com\indigloo\seo\StringUtil as SeoStringUtil ;
     use \com\indigloo\Configuration as Config ;
     
    class Post {

        function create($title,$summary,$description,
                        $linksJson,$imagesJson,$userId,$userName) {
            
            $seoTitle = SeoStringUtil::convertNameToSeoKey($title);
            $data = mysql\Post::create($title,$seoTitle,$summary,$description,
                                       $linksJson,$imagesJson,$userId,$userName);
            return $data ;
        }
        
        function createLink($title,$summary,$link) {
            $data = mysql\Post::createLink($title,$summary,$link);
            return $data ;
        }
        
        function update($postId,$title,$summary,$description,$linksJson,$imagesJson) {
            Util::isEmpty('post_id',$postId);
            $seoTitle = SeoStringUtil::convertNameToSeoKey($title);
            $data = mysql\Post::update($postId,$title,$seoTitle,$summary,$description,$linksJson,$imagesJson);
            return $data ;
        }
        
        function getRecordOnId($postId) {
            $row = mysql\Post::getRecordOnId($postId);
            return $row ;
        }
        
        function getRecordOnShortId($shortId) {
            $row = mysql\Post::getRecordOnShortId($shortId);
            return $row ;
        }
        
        function getLatestRecords() {
            
            $pageSize = Config::getInstance()->get_value("system.page.records");
            $rows = mysql\Post::getLatestRecords($pageSize);
            return $rows ;

        }
        
        function getRecords($start,$direction) {
            $pageSize = Config::getInstance()->get_value("system.page.records");
            $rows = mysql\Post::getRecords($start,$direction,$pageSize);
            return $rows ;

        }
        
        function getTotalPages() {
            $count = $this->getRecordsCount();
            $pageSize = Config::getInstance()->get_value("system.page.records");
            $totalPages = ceil($count / $pageSize);
            return $totalPages ;
        }
        
        function getRecordsCount() {
            $row = mysql\Post::getRecordsCount();
            return $row['count'] ;
        }
        
    }

}
?>
