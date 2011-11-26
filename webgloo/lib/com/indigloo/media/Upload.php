<?php

/*
 *
 *
 *
 * jha.rajeev@gmail.com created for HTTP file upload 
 *
 * 1)
 * see the following php.ini settings
 *  - post_max_size 
 *  - upload_max_filesize
 *  The size limits here should be compatible with limits below
 * 
 * 2) webserver should have write permission on server TEMP dir 
 * 3) Also, an empty file input box is always set to an array 
 *  so isset($_FILES[$fieldName]) is redundant , this field is never empty 
 *
 *
 */

namespace com\indigloo\media {

    use com\indigloo\Configuration as Config;
    use com\indigloo\Logger;
    
    class Upload {
        const ERROR_FIELD_MISSING = " No file found in post! Did you upload a file?";
        const ERROR_INI_SIZE= " file size greater than php.ini upload_max_file ";
        const ERROR_PARTIAL = " partial file received ";
        const ERROR_NO_FILE = " no file selected on form ";
        const ERROR_FILE_SIZE = " file size is greater than : ";
        const ERROR_UNKNOWN = " unknown PHP error during file upload  ";

        private $isRequired;
        private $isEmpty;
        private $isError;
        private $errorMessage;
        private $size;
        private $mime;
        private $maxSize;
        private $orgId;
        private $fileData;
        private $name;

        function __construct() {

            $this->isRequired = true;
            $this->isError = false;
            $this->isEmpty = false;
            $this->fileData = NULL;
        }

        function __destruct() {
            
        }

        public function hasError() {
            return $this->isError;
        }

        public function setError($flag) {
            $this->isError = $flag;
        }

        //No empty setter
        public function isRequired() {
            return $this->isRequired;
        }

        // if file field can be empty on form
        public function setRequired($flag) {
            $this->isRequired = $flag;
        }

        public function getErrorMessage() {
            return $this->errorMessage;
        }

        public function setErrorMessage($message) {
            $this->errorMessage = $errorMessage;
        }

        public function getMime() {
            return $this->mime;
        }

        public function setMime($mime) {
            $this->mime = $mime;
        }

        public function getMaxSize() {
            return $this->maxSize;
        }

        public function setMaxSize($size) {
            $this->maxSize = $size;
        }

        public function getSize() {
            return $this->size;
        }

        public function setSize($size) {
            $this->size = $size;
        }

        public function getName() {
            return $this->name;
        }

        public function setName($name) {
            $this->name = $name;
        }

        public function getOrgId() {
            return $this->orgId;
        }

        public function setOrgId($orgId) {
            $this->orgId = $orgId;
        }

        public function getFileData() {
            return $this->fileData;
        }

        public function isEmpty() {
            return $this->isEmpty;
        }

        public function process($fieldName) {
            $maxSize = Config::getInstance()->max_file_size();
            if (empty($maxSize) || is_null($maxSize)) {
                trigger_error('file maxsize is not set in config file',E_USER_ERROR);
            }
            
            $this->setMaxSize($maxSize);
            
            if (!isset($_FILES[$fieldName]) || empty($_FILES[$fieldName]['name'])) {
                // error when files are required on web form
                if ($this->isRequired) {
                    $this->isError = true;
                    $this->errorMessage = self::ERROR_FIELD_MISSING;
                    // ok otherwise
                } else {
                    $this->isEmpty = true;
                }
                return;
            }

            // form field is set
            $this->fileData = $_FILES[$fieldName];
            //get original file name
            $this->name = $_FILES[$fieldName]['name'];

            /* check for all possible error codes */
            switch ($this->fileData['error']) {
                case UPLOAD_ERR_INI_SIZE:
                    // image size > php.ini setting
                    $this->isError = true;
                    $this->errorMessage = self::ERROR_INI_SIZE;
                    break;


                case UPLOAD_ERR_PARTIAL :
                    // partial upload
                    $this->isError = true;
                    $this->errorMessage = self::ERROR_PARTIAL;
                    break;

                case UPLOAD_ERR_NO_FILE:
                    // no file selected for upload
                    if ($this->isRequired) {
                        $this->isError = true;
                        $this->errorMessage = self::ERROR_NO_FILE;
                    }

                    break;

                case UPLOAD_ERR_FORM_SIZE:
                    // file too large vis-a-vis hidden form field
                    // Users can fake this one
                    $this->isError = true;
                    $this->errorMessage = self::ERROR_FILE_SIZE . $this->maxSize;
                    break;
                case UPLOAD_ERR_OK :
                    //check for file data size
                    if ($this->fileData['size'] > $this->maxSize) {
                        // image size too large
                        $this->isError = true;
                        $this->errorMessage = self::ERROR_FILE_SIZE . $this->maxSize;
                    }
                    break;
                default :
                    // unknown error
                    $this->isError = true;
                    $this->errorMessage = self::ERROR_UNKNOWN;
            }
        }

        // process over
    }

}
?>