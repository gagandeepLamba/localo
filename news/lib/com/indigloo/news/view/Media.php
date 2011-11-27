<?php


namespace com\indigloo\news\view {

    class Media {
        
        public $id ;
        public $mime ;
        public $storeName;
        public $size ;
        public $originalName;
        public $height;
        public $width ;
        public $bucket ;
        
        
        static function create($row) {
            //print_r($row);
            $media = new Media();
            $media->id = $row['id'];
            $media->originalName = $row['original_name'];
            $media->storeName = $row['stored_name'];
            $media->size = $row['size'];
            $media->mime = $row['mime'];
            $media->bucket = $row['bucket'];
            $media->height = $row['original_height'];
            $media->width = $row['original_width'];

            return $media ;
        }

    }

}
?>
