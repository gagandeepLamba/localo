<?php

//some comments

namespace webgloo\job\view {

    class Document {
         //unique ID for this user
        public $uuid ;
        public $mime ;
        public $storeName;
        public $size ;
        public $isOrphan ;
        public $originalName;
        
        //create one from DB Row
        function create($row) {
            $document = new Document();
            $document->uuid = $row['id'];
            $document->originalName = $row['original_name'];
            $document->storeName = $row['store_name'];
            $document->size = $row['size'];
            $document->mime = $row['mime'];
            $document->isOrphan = $row['is_orphan'];
            return $document ;
        }

    }

}
?>
