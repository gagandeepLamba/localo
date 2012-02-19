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
    
    class FileUpload {

        private $prefix ;
        private $pipe ;
        private $mediaData ;
        private $errors ;
        
        function __construct($pipe) {
            $this->pipe = $pipe ;
            $this->prefix ='';
            $this->errors = array();
            
        }

        function __destruct() {
        
        }

        public function getMediaData() {
            return $this->mediaData;
        }
        
        public function getErrors() {
            return $this->errors;
        }
        
        public function setPrefix($prefix){
            $this->prefix = $prefix ;
        }
        
        public function getPrefix() {
            return $this->prefix;
        }
        
        function process($fieldName) {
            $sBlobData = $this->getOriginalFileData($fieldName);
            $this->persist($sBlobData);
        }
        
        function getOriginalFileData($fieldName){
            
            $this->pipe->process($fieldName);
            $this->errors = $this->pipe->getErrors();
            $this->mediaData = $this->pipe->getMediaData();
            
            if(sizeof($this->errors) > 0 ) {
                return ;
            }
            
            $sBlobData = $this->pipe->getFileData();
            
            if (is_null($sBlobData)) {
                trigger_error('File processing returned Null Data', E_USER_ERROR);
            }
            
            return $sBlobData ;
        }

        function persist($name,$sBlobData) {
            
            $token = $name.date(DATE_RFC822);
            $storeName = substr(md5($token), rand(1, 15), 16).rand(1,4096);
            $pos = strrpos($name, '.');
            
            if ($pos != false) {
                //separate filename and extension
                $extension = substr($name, $pos + 1);
                $storeName =  $storeName. '.' . $extension;
            } 
            
            $storeName =  $this->prefix.$storeName.
            
            
            $fp = NULL;
            //system.upload.path has a trailing slash
            $path = Config::getInstance()->get_value('system.upload.path').$storeName;
            
            if(!file_exists(dirname($path))) {
                mkdir(dirname($path), 0755, true);
            }
            
            if(Config::getInstance()->is_debug()){
                Logger::getInstance()->debug(" file name = $name");
                Logger::getInstance()->debug(" storage path is => $path ");
            }
            
            //open file in write mode
            $fp = fopen($path, 'w');
            fwrite($fp, $sBlobData);
            fclose($fp);   
            
            return $storeName;
        }

    }
}

?>
