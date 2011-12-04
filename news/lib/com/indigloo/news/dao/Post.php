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
        
        function createLink($title,$summary,$link) {
            $seoTitle = \com\indigloo\seo\StringUtil::convertNameToSeoKey($title);
            $data = mysql\Post::createLink($title,$seoTitle,$summary,$link);
            return $data ;
        }
        
        function update($postId,$title,$summary,$description) {
            Util::isEmpty('post_id',$postId);
            $seoTitle = \com\indigloo\seo\StringUtil::convertNameToSeoKey($title);
            $data = mysql\Post::update($postId,$title,$seoTitle,$summary,$description);
            return $data ;
        }
        
        function updateLink($postId,$title,$summary,$link) {
            Util::isEmpty('post_id',$postId);
            
            $seoTitle = \com\indigloo\seo\StringUtil::convertNameToSeoKey($title);
            $data = mysql\Post::updateLink($postId,$title,$seoTitle,$summary,$link);
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
        
        function getRecordsWithMedia($pageNo,$pageSize) {
            $rows = mysql\Post::getRecordsWithMedia($pageNo,$pageSize);
            return $rows ;

        }
        
        function getRecordsWithMediaCount() {
            $row = mysql\Post::getRecordsWithMediaCount();
            return $row['count'] ;
        }
        
        
    }

}
?>
