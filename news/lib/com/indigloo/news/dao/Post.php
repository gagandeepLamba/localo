<?php

namespace com\indigloo\news\dao {

    
    use com\indigloo\Util as Util ;
    use com\indigloo\news\mysql as mysql;
    
    class Post {

        function create($title,$summary,$description) {
            $seoTitle = \com\indigloo\seo\StringUtil::convertNameToSeoKey($title);
            $data = mysql\Post::create($title,$seoTitle,$summary,$description);
            return $data ;
        }
        
        function update($postId,$title,$summary,$description) {
            Util::isEmpty('post_id',$postId);
            $seoTitle = \com\indigloo\seo\StringUtil::convertNameToSeoKey($title);
            $data = mysql\Post::update($postId,$title,$seoTitle,$summary,$description);
            return $data ;
        }
        
        function getRecordOnId($postId) {
            $row = mysql\Post::getRecordOnId($postId);
            return $row ;
        }
        
        function getMediaOnId($postId) {
            $rows = mysql\Post::getMediaOnId($postId);
            return $rows ;
        }
        
        function getRecordOnSeoTitle($seoTitle) {
            $row = mysql\Post::getRecordOnSeoTitle($seoTitle);
            return $row ;
        }
        
        function getRecords() {
            $rows = mysql\Post::getRecords();
            return $rows ;

        }
        
        function getRecordsWithMedia() {
            $rows = mysql\Post::getRecordsWithMedia();
            return $rows ;

        }
        
    }

}
?>
