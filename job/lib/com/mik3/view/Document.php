<?php


namespace com\3mik\view {

    class Document {
         //unique ID for this user
        public $uuid ;
        public $mime ;
        public $storeName;
        public $size ;
        public $isOrphan ;
        public $originalName;

        public $entityName;
        public $entityId;

        //create one from DB Row
        function create($row) {
            $document = new Document();
            $document->uuid = $row['id'];
            $document->originalName = $row['original_name'];
            $document->storeName = $row['store_name'];
            $document->size = $row['size'];
            $document->mime = $row['mime'];

            $document->isOrphan = $row['is_orphan'];
            $document->entityId = $row['entity_id'];
            $document->entityName = $row['entity_name'];

            return $document ;
        }

    }

}
?>
