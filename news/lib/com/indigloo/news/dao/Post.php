<?php

namespace com\indigloo\news\dao {

    
    use \com\indigloo\Util as Util ;
    use \com\indigloo\news\mysql as mysql;
    use \com\indigloo\seo\StringUtil as SeoStringUtil ;
    
    class Post {

        function create($title,$summary,$description) {
            $seoTitle = SeoStringUtil::convertNameToSeoKey($title);
            //change description (markdown) to html
            $parser = new \ext\MarkdownParser();
            $html = $parser->transform($description);
            $data = mysql\Post::create($title,$seoTitle,$summary,$description,$html);
            return $data ;
        }
        
        function createLink($title,$summary,$link) {
            $data = mysql\Post::createLink($title,$summary,$link);
            return $data ;
        }
        
        function update($postId,$title,$summary,$description) {
            Util::isEmpty('post_id',$postId);
            $seoTitle = SeoStringUtil::convertNameToSeoKey($title);
            //change description (markdown) to html
            $parser = new \ext\MarkdownParser();
            $html = $parser->transform($description);
            
            $data = mysql\Post::update($postId,$title,$seoTitle,$summary,$description,$html);
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
        
        function getRecordOnShortId($shortId) {
            $row = mysql\Post::getRecordOnShortId($shortId);
            return $row ;
        }
        
        function getLatestPostWithMedia() {
            //@todo read pagesize from config file
            $rows = mysql\Post::getLatestPostWithMedia(20);
            return $rows ;

        }
        
        function getPostWithMedia($start,$direction) {
            //@todo read pagesize from config file
            $rows = mysql\Post::getPostWithMedia($start,$direction,20);
            return $rows ;

        }
        
    }

}
?>
