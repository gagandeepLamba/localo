<?php


namespace com\indigloo\media {

    use com\indigloo\Configuration as Config;
    use com\indigloo\Logger;
    
    class ImageUpload extends \com\indigloo\media\FileUpload {

        private $height ;
        private $width ;
        
        function __construct() {
            parent::__construct();
        }

        function __destruct() {
            parent::__destruct();
        }
        
        public function getWidth() {
            return $this->width;
        }

        public function getHeight() {
            return $this->height;
        }
         
        public function process($fieldName) {
            $sBlobData = parent::getOriginalFileData($fieldName);
            //do image specific processing here
            $this->computeHW($sBlobData);
            parent::store($sBlobData);
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
            $this->width = imagesx($oSourceImage);
            $this->height = imagesy($oSourceImage);
            
        }
        
    }
}

?>
