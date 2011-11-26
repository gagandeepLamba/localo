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

namespace com\mik3 {

    use com\indigloo\Configuration as Config;
    use com\indigloo\Logger;
    
    class FileUpload extends \com\indigloo\Upload {

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
            
            $maxSize = Config::getInstance()->max_file_size();
            if (empty($maxSize) || is_null($maxSize)) {
                trigger_error('file maxsize is not set in config file',E_USER_ERROR);
            }
            
            parent::setMaxSize($maxSize);
            parent::process($fieldName);
            
            //error or empty field - return
            if (parent::hasError() || parent::isEmpty()) {
                return;
            }
            
            $fileData = parent::getFileData();
            if (is_null($fileData)) {
                trigger_error('File processing returned Null Data', E_USER_ERROR);
            }
            $this->store($fileData);
        }

        private function store($fileData) {
            
            $ftmp = $fileData['tmp_name'];
            $fname = $fileData['name'];
            $mime = $fileData['type'];

            $oTempFile = fopen($ftmp, "rb");
            $size = filesize($ftmp);
            $sBlobData = fread($oTempFile, $size);

            $pos = strrpos($fname, '.');

            if ($pos != false) {
                //separate filename and extension
                $extension = substr($fname, $pos + 1);
                $fname = substr($fname, 0, $pos);
                $this->storeName =  md5($fname) . '.' . $extension;
            } else {
                $this->storeName = md5($fname);
            }
            
            $fp = NULL;
            $path = Config::getInstance()->get_value('system.upload.path').$this->storeName;
            
            if(Config::getInstance()->is_debug()){
                Logger::getInstance()->debug(" file name = $fname, mime = $mime ");
                Logger::getInstance()->debug(" storage path is => $path ");
            }
            
            //open file in write mode
            $fp = fopen($path, 'w');
            fwrite($fp, $sBlobData);
            fclose($fp);
            
            //set size and MIME type
            parent::setSize($size);
            parent::setMime($mime);
        }

    }
}

?>
