<?php

namespace com\indigloo\media {

    use com\indigloo\Configuration as Config;
    use com\indigloo\Logger;
    
    class XHRUpload {
        
        private $errors;
        private $fileData;
        private $mediaData ;

        function __construct() {
            $this->errors = array();
            $this->fileData = NULL;
            $this->mediaData = new \com\indigloo\media\Data();
        }

        function __destruct() {
            
        }

        public function getErrors() {
            return $this->errors;
        }

        public function getMediaData() {
            return $this->mediaData;
        }
        
        public function getFileData() {
            return $this->fileData;
        }
        
        private function addError($error) {
            array_push($this->errors,$error) ;
        }
        

        public function process($originalName) {
			
            $this->mediaData->originalName = $originalName ;
            //@todo set $this->mediaData->mime
			//@todo $this->mediaData->size = $realSize ;
			$this->mediaData->mime = 'mime/dummy' ;
			$this->mediaData->size = 1024 ;
			
            $this->fileData = file_get_contents('php://input') ;
            
            
            return ;
        }
        
    }

}
?>