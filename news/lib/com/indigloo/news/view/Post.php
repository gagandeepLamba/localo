<?php


namespace com\indigloo\news\view {

    class Post {
        
        public $id ;
        public $title ;
        public $seoTitle;
        public $summary ;
        public $description;
        public $mediaJson;
        
        static function create($row) {
             
            $post = new Post();
            $post->id = $row['id'];
            $post->title = $row['title'];
            $post->summary = $row['summary'];
            $post->description = $row['description'];
            $post->mediaJson = $row['media_json'];
            $post->createdOn = $row['created_on'];
            $post->seoTitle = $row['seo_title'];
            
            return $post ;
        }

    }

}
?>
