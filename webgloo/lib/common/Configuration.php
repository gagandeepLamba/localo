<?php

/*
 *
 * Abstraction for application specific configuration file.
 * we load only one instance of this class so do not try to load
 * two applications into same memory space. in other words two applications
 * setting different config file location will result in unstable/undefined behavior.
 * PHP  singleton implementation need not be thread safe!
 * I do not think there is even the concept of thread safe in PHP!
 *
 *
 *
 */

namespace webgloo\common {

    class Configuration {

        static private $instance = NULL;
        private $ini_array;

        static function getInstance() {
            if (self::$instance == NULL) {
                self::$instance = new Configuration();
            }

            return self::$instance;
        }

        function __construct() {
            //each application will read from its own config file
            $iniFile = $_SERVER['APP_CONFIG_PATH'];
            file_exists($iniFile) || die("unable to open app_config.ini file ");
            // create config object
            $this->ini_array = parse_ini_file($iniFile);
        }

        function isRequired($name, $value) {

            if (empty($value)) {
                trigger_error("Default $name is empty in config", E_USER_ERROR);
            }
            return $value;
        }

        function get_value($key) {
            return $this->ini_array[$key];
        }

        function __destruct() {
            
        }

        function mysql_host() {
            return $this->ini_array['mysql.host'];
        }

        function mysql_db() {
            return $this->ini_array['mysql.database'];
        }

        function mysql_user() {
            return $this->ini_array['mysql.user'];
        }

        function mysql_password() {
            //fetch encrypted password
            $password = $this->ini_array['mysql.password'];
            //$password = Gloo_Util::base64Decrypt($encpassword);
            return $password;
        }

        function is_debug() {
            $val = $this->ini_array['debug.mode'];
            if (intval($val) == 1) {
                return true;
            } else {
                return false;
            }
        }

        function log_level() {
            return $this->ini_array['log.level'];
        }

        function system_page_records() {
            return $this->ini_array['system.page.records'];
        }

        function max_file_size() {
            return $this->ini_array['max.file.size'];
        }

        function max_foto_size() {
            return $this->ini_array['max.foto.size'];
        }

        function thumbnail_width() {
            return $this->ini_array['thumbnail.width'];
        }

        function thumbnail_height() {
            return $this->ini_array['thumbnail.height'];
        }

        function aws_bucket() {
            return $this->ini_array['aws.bucket'];
        }

        function aws_access_key() {
            return $this->ini_array['aws.access.key'];
        }

        function aws_secret_key() {
            return $this->ini_array['aws.secret.key'];
        }

        function image_404_uri() {
            return $this->ini_array['image.404.uri'];
        }

        function thumbnail_404_uri() {
            return $this->ini_array['thumbnail.404.uri'];
        }

        function smtp_host() {
            return $this->ini_array['smtp.host'];
        }

        function smtp_port() {
            return $this->ini_array['smtp.port'];
        }

        function smtp_user() {
            return $this->ini_array['smtp.user'];
        }
        
        //@todo - donot use plain text password
        function smtp_password() {
            $password = $this->ini_array['smtp.password'];
            return $password;
        }
        
        function log_location() {
            return $this->ini_array['log.location'];
        }

        function getFarmName() {
            return $this->ini_array['farm.name'];
        }
        
    }

}
?>
