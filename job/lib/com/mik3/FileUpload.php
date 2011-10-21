<?php

/**
 *
 * @author rajeevj
 * Usage: $uploader = new FileUploader();
 * $uploader->process("f");
 * if($uploader->hasError()) {
 *   //use $uploader->getErrorMessage();
 *
 * } else {
 *  //process further
 *
 * }
 *
 *
 */

namespace com\3mik {

    use com\indigloo\common\Configuration as Config;
    use com\indigloo\common\Logger;
    
    class FileUpload extends \webgloo\common\Upload {

        private $storeName ;

        function __construct() {
            //call parent constructor
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
                //default to 10 MB or 10240000 KB
                $maxSize = 10240000;
            }
            
            //set file size limit on uploader
            parent::setMaxSize($maxSize);
            parent::process($fieldName);
            //error or empty field - no further processing required
            if (parent::hasError() || parent::isEmpty()) {
                return;
            }
            //processing required now
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
            //file BLOB
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
