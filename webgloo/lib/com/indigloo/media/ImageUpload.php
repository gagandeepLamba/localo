<?php


namespace com\indigloo\media {

    use com\indigloo\Configuration as Config;
    use com\indigloo\Logger;
    
    class ImageUpload  {

       
        private $pipe ;
        private $store ;
        private $mediaData ;
        private $errors ;
        private $isS3Pipe ;
        
        function __construct($pipe) {
            $this->pipe = $pipe ;
            if(Config::getInstance()->get_value("file.store") == 's3'){
                $this->store = new \com\indigloo\media\S3Store() ;
                $this->isS3Pipe = true ;
            } else {
                $this->store = new \com\indigloo\media\FileStore() ;
                $this->isS3Pipe = false ;
            }

            $this->errors = array() ;
            $this->mediaData = NULL ;
        }

        function __destruct() {
            
        }
        
        public function getMediaData() {
            return $this->mediaData;
        }
        
        public function getErrors() {
            return $this->errors;
        }
        
        public function process($prefix,$fieldName) {
            $this->pipe->process($fieldName);
            $this->errors = $this->pipe->getErrors();

            if(sizeof($this->errors) > 0 ){
                //set errors and return 
                return ;

            }

            //get meta data and actual file data 
            $this->mediaData = $this->pipe->getMediaData();
            $sBlobData = $this->pipe->getFileData();

            if (is_null($sBlobData)) {
                trigger_error('File processing returned Null Data', E_USER_ERROR);
            }
             
            //do image specific processing here
            $this->computeHW($sBlobData);
            $storeName = $this->store->persist($prefix,$this->mediaData->originalName,$sBlobData);

            if(is_null($storeName)) {
                array_push($this->errors, "file storage failed");
                return ;
            }

            $this->mediaData->storeName = $storeName;
            if($this->isS3Pipe) {
                $this->mediaData->store = 's3';
                $this->mediaData->bucket = Config::getInstance()->get_value("aws.bucket"); 
                //absolute URL for s3 
                $this->mediaData->fullUrl = "http://".$this->mediaData->bucket."/".$storeName ;
            } else {
                $this->mediaData->store = 'local';
                //relative URL for local uploads
                $this->mediaData->bucket = 'media'; 
                $this->mediaData->fullUrl = "/media/".$storeName ;
            }

        }
        
        public function computeHW($sBlobData) {
            //compute height and width using GD2 functions
            // GD2 function in global namespace
            $oSourceImage = \imagecreatefromstring($sBlobData);
            if ($oSourceImage == false) {
                //unrecoverable error
                $errorMsg = "GD2 : Not able to create source image from supplied file data ";
                trigger_error($errorMsg, E_USER_ERROR);
            }
            
            //original width and height
            $this->mediaData->width = imagesx($oSourceImage);
            $this->mediaData->height = imagesy($oSourceImage);
            
        }
        
    }
}

?>
