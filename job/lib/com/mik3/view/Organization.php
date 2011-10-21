<?php


namespace com\mik3\view {

    class Organization {

        //unique ID for this organization
        public $uuid;
        public $name;
        //sanitized email
        public $email;
        public $domain ;
        public $description;
        
        function __construct() {
           
        }

    }
    
}
?>
