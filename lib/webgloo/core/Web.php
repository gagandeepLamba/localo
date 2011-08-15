<?php

/**
 *
 * @author rajeevj
 * 
 * Web is a  class that lets you access request and context
 * and exposes other helper methods also. Only one instance is in effect
 * during processing of a request.
 *
 * This naming was influenced by web.py micro framework. This glue class lets
 * part of the system interact with each other much on the lines of web.py
 *
 * 
 * 
 */

namespace webgloo\core {

    use webgloo\common\Configuration as Config;
    use webgloo\common\Logger as Logger;
    use webgloo\common\Util ;
    
    class Web {

        private $request;
        static private $instance = NULL;

        private function __construct() {
            $this->request = new \webgloo\core\Request();
        }

        static function getInstance() {
            if (self::$instance == NULL) {
                self::$instance = new Web();
            }
            return self::$instance;
        }

        function getRequest() {
            return $this->request;
        }

        //request helper methods
        function getRequestParam($param) {
            return $this->request->getParam($param);
        }

        function getRequestAttribute($key) {
            return $this->request->getAttribute($key);
        }

        function setRequestAttribute($key, $value) {
            return $this->request->setAttribute($key, $value);
        }

        function store($key, $value) {
           
            if (isset($_SESSION)) {
                $_SESSION[$key] = $value;
                
                if (Config::getInstance()->is_debug()) {
                    Logger::getInstance()->debug('web >> storing in session >> key is:: ' . $key);
                    Logger::getInstance()->debug($value);
                }
            }
        }

        function find($key, $destroy=false) {
            $value = NULL;

            if (isset($_SESSION[$key]) && !empty($_SESSION[$key])) {
                $value = $_SESSION[$key];
                if (Config::getInstance()->is_debug()) {             
                    Logger::getInstance()->debug('web >> fetching from session >> key is:: ' . $key);
                    Logger::getInstance()->debug($value);
                }

                if ($destroy) {
                    //remove this from session
                    $_SESSION[$key] = NULL;
                    if (Config::getInstance()->is_debug()) {
                        Logger::getInstance()->debug('web >> removed from session >> key is:: ' . $key);
                    }
                }
            }
            return $value;
        }

        //@todo - pass a class with a well defined interface
        // we need to call a particular method on that class

        function start() {

            if (Config::getInstance()->is_debug()) {
                Logger::getInstance()->debug('web >> start >> hash is:: ' . spl_object_hash(self::$instance));
            }
        }

        function end() {
            if (Config::getInstance()->is_debug()) {
                Logger::getInstance()->debug('web >> end >> hash is:: ' . spl_object_hash(self::$instance));
            }

            /*
              Gloo_DB::getInstance()->closeConnection();
              if (Gloo_Config::getInstance()->is_debug()) {
              $eop = "\n\n";
              Gloo_Logger::getInstance()->debug('web >> end request >> hash is >> ' . spl_object_hash(self::$instance) . $eop);
              } */
        }

    }

}
?>
