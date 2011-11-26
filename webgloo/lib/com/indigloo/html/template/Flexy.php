<?php

/**
 *
 * Gloo_Flexy is a wrapper over PEAR package HTML_Template_Flexy
 *
 * @author rajeevj
 * @dependency PEAR class HTML_TEMPLATE_FLEXY
 *
 */

namespace com\indigloo\html\template {


    class Flexy {

        static private $instance = NULL;

        private function __construct() {

        }

        static function getOptions() {
            $options = array(
                'templateDir' => $_SERVER['WEB_TEMPLATE_DIR'],
                'compileDir' => $_SERVER['WEB_TEMPLATE_COMPILE_DIR'],
                'compiler' => 'Flexy',
                'locale' => 'en',
                'debug' => 0
            );
            return $options;
        }

        static function getInstance() {
            if (self::$instance == NULL) {
                // set template options
                //@see also http://pear.php.net/manual/en/package.html.html-template-flexy.configuration.php
                // initialize template engine
                //load from global namespace
                $flexy = new \HTML_Template_Flexy(self::getOptions());
                self::$instance = $flexy;
            }
            return self::$instance;
        }

    }

}
?>
