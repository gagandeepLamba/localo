<?php

namespace com\indigloo\ui\form {

    use com\indigloo\Configuration as Config;
    use com\indigloo\Logger as Logger;
    use com\indigloo\Util as Util;

    class Handler {

        private $post;
        private $fname;
        private $ferrors;
        private $fvalues;
        private $processed;

        function __construct($fname, $post) {
            $this->fname = $fname;
            $this->post = $post;
            //collection of processed key-value pairs
            //keys are form element names
            // and values are output of form handler
            $this->fvalues = array();
            //errors array
            $this->ferrors = array();
            $this->processed = array();
        }

        function addRule($name, $displayName, $rules) {
            if (!isset($this->post) || sizeof($this->post) == 0) {
                trigger_error(' Form handler POST array not set', E_USER_ERROR);
            }

            //get processed value first
            $value = NULL;

            if (isset($this->post[$name])) {
                $value = trim($this->post[$name]);
                //Apply rules on this value and store
                $this->processValue($name, $displayName, $value, $rules);
                //processed this element
                array_push($this->processed, $name);
            } else {
                //this key is not found in post
                // this represents a coding issue, not a form error
                // if the element is on form then you get a key
                trigger_error(' Form handler POST does not have element :: ' . $name, E_USER_ERROR);
            }
        }

        function processValue($name, $displayName, $value, $rules) {
            //see size of error queue before processing this element
            $errorSize1 = sizeof($this->ferrors);

            foreach ($rules as $ruleName => $ruleCondition) {
                $this->processRule($ruleName, $ruleCondition, $displayName, $value);
            }

            //see error queue size after processing this value
            $errorSize2 = sizeof($this->ferrors);
            if ($errorSize2 == $errorSize1) {
                //Add to values collection if we found no error
                //All rules processed - add to collection
                // we run the rules on raw version
                // but we should add the sanitized version for our consumption

                $this->fvalues[$name] = self::getSecureHtml($value);
            } else {
                if (Config::getInstance()->is_debug()) {
                    Logger::getInstance()->debug("Form processed $name and rules :: ");
                    Logger::getInstance()->debug($rules);
                    Logger::getInstance()->debug("Errors found :: " . ($errorSize2 - $errorSize1));
                }
            }
        }

        function processRule($ruleName, $ruleCondition, $displayName, $value) {

            switch ($ruleName) {
                case 'maxlength' :
                    //if supplied value length exceeds ruleCondition
                    if (strlen($value) > $ruleCondition) {
                        array_push($this->ferrors, $displayName . " exceeds maximum allowed length :: " . $ruleCondition);
                    }
                    break;
                case 'minlength' :
                    //if supplied value length is less than ruleCondition
                    if (strlen($value) < $ruleCondition) {
                        array_push($this->ferrors, $displayName . " is less than minimum required length :: " . $ruleCondition);
                    }
                    break;
                case 'maxval' :
                    //if supplied value length is less than ruleCondition
                    if (intval($value) > $ruleCondition) {
                        array_push($this->ferrors, $displayName . " exceeds allowed value of :: " . $ruleCondition);
                    }
                    break;
                case 'minval' :
                    //if supplied value length is less than ruleCondition
                    if (intval($value) < $ruleCondition) {
                        array_push($this->ferrors, $displayName . " is less than :: " . $ruleCondition);
                    }
                    break;
                case 'required' :
                    if (strlen($value) == 0) {
                        array_push($this->ferrors, $displayName . " is a required field");
                    }
                    break;
                case 'equal':
                    if (strcmp($value, $ruleCondition) != 0) {
                        array_push($this->ferrors, $displayName . " is not equal to :: " . $ruleCondition);
                    }
                    break;
            }
        }

        function addError($error) {
            array_push($this->ferrors, $error);
        }

        function getErrors() {
            if ($this->hasErrors() && Config::getInstance()->is_debug()) {
                Logger::getInstance()->debug($this->fname . " >> posted following errors >> " . Util::stringify($this->ferrors));
            }
            return $this->ferrors;
        }

        function getValues() {
            foreach ($this->post as $key => $value) {
                if (in_array($key, $this->processed)) {
                    //already done
                    // because we ran some rules there
                } else {
                    //add sanitized output
                    $this->fvalues[$key] = self::getSecureHtml($value);
                }
            }
            return $this->fvalues;
        }

        function getDecoded($name) {
            $val = $this->fvalues[$name];
            $val = htmlspecialchars_decode($val, ENT_QUOTES);
            return $val;
        }

        function hasErrors() {
            if (sizeof($this->ferrors) > 0) {
                return true;
            } else {
                return false;
            }
        }

        function push($name, $value) {
            $this->fvalues[$name] = $value;
        }

        static function sanitize($vars, $name) {
            // by default keep null string as return value
            $value = '';
            if (isset($vars[$name])) {
                $value = self::getSecureHtml($vars[$name]);
            }
            return $value;
        }

        static function getSecureHtml($x) {
            return trim(htmlspecialchars($x, ENT_QUOTES));
        }

    }

}
?>
