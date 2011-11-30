<?php

/**
 
@author rajeevj
    Usage:
    
    $uploader = new FileUploader();
    $uploader->process("f");
    if($uploader->hasError()) {
        //use $uploader->getErrorMessage();
     
    } else {
        //process further
     
    }
 
 
 */

namespace com\indigloo\media {

    use com\indigloo\Configuration as Config;
    use com\indigloo\Logger;
    
    class FileUpload extends \com\indigloo\media\Upload {

        private $storeName ;

        function __construct() {
            parent::__construct();
        }

        function __destruct() {
            parent::__destruct();
        }

        public function getStoreName() {
            return $this->storeName;
        }
        
        public function process($fieldName) {
            $sBlobData = $this->getOriginalFileData($fieldName);
            $this->store($sBlobData);
        }
        
        public function getOriginalFileData($fieldName){
            parent::process($fieldName);
            
            //error or empty field - return
            if (parent::hasError() || parent::isEmpty()) {
                return NULL;
            }
            
            $fileData = parent::getFileData();
            
            if (is_null($fileData)) {
                trigger_error('File processing returned Null Data', E_USER_ERROR);
            }
            
            $ftmp = $fileData['tmp_name'];
            $fname = $fileData['name'];
            $mime = $fileData['type'];
            $this->name = $fname ;
            
            $oTempFile = fopen($ftmp, "rb");
            $size = filesize($ftmp);
            
            //set size and MIME type
            parent::setSize($size);
            parent::setMime($mime);
            
            $sBlobData = fread($oTempFile, $size);
            return $sBlobData ;
        }

        function store($sBlobData) {
           
            $token = $this->name . date(DATE_RFC822);
            $this->storeName = substr(md5($token), rand(1, 15), 16).rand(1, 4096);
            $pos = strrpos($this->name, '.');
            
            if ($pos != false) {
                //separate filename and extension
                $extension = substr($this->name, $pos + 1);
                $this->storeName =  $this->storeName. '.' . $extension;
            } 
            

            $fp = NULL;
            $path = Config::getInstance()->get_value('system.upload.path').$this->storeName;
            
            if(Config::getInstance()->is_debug()){
                Logger::getInstance()->debug(" file name = $this->name, mime = $mime ");
                Logger::getInstance()->debug(" storage path is => $path ");
            }
            
            //open file in write mode
            $fp = fopen($path, 'w');
            fwrite($fp, $sBlobData);
            fclose($fp);
            
         
        }

    }
}

?>
