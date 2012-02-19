<?php


namespace com\indigloo\media {

    use com\indigloo\Configuration as Config;
    use com\indigloo\Logger;
    
    class ImageUpload  {

       
        private $store ;
        private $mediaData ;
        private $errors ;
        
        function __construct($store) {
            $this->store = $store ;
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
        
        public function process($fieldName) {
            $sBlobData = $this->store->getOriginalFileData($fieldName);
            $this->errors = $this->store->getErrors();
            $this->mediaData = $this->store->getMediaData();
            
            //do image specific processing here
            $this->computeHW($sBlobData);
            $storeName = $this->store->persist($this->mediaData->originalName,$sBlobData);
            $this->mediaData->storeName = $storeName;
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
