<?php

namespace webgloo\common {


    class Util {

        static function base64Encrypt($token) {
            $token = base64_encode($token);
            $token = str_rot13($token);
            return $token;
        }

        static function base64Decrypt($token) {
            $token = str_rot13($token);
            $token = base64_decode($token);
            return $token;
        }

        static function getBase36GUID() {
            $baseId = rand();
            $token = base_convert($baseId * rand(), 10, 36);
            return $token;
        }

        static function getMD5GUID() {
            $token = md5(uniqid(mt_rand(), true));
            return $token;
        }

        static function array2nl($arr) {
            //lambda style function
            // Anonymous callback @see create_function() on php.net
            $str = array_reduce($arr, create_function('$a,$b', 'return $a."\n".$b ;'));
            return $str;
        }

        static function stringify($var) {
            $buffer = '';
            //var_dump($var);
            if (is_object($var)) {
                $buffer = '{object=' . $var->__toString() . '}';
                return $buffer;
            }
            if (is_array($var)) {
                $buffer = '[array=';
                foreach ($var as $elem) {
                    $buffer = $buffer . self::stringify($elem) . ',';
                }
                $buffer .= ']';
                return $buffer;
            }

            return $var;
        }

        /**
         *
         * @param <type> $original - timestamp coming from mysql DB
         * @param <type> $format   - output format , defaults to dd mon yyyy
         * @return <type> the formatted date string
         *
         * @see also http://in2.php.net/strftime
         * @see also http://in2.php.net/manual/en/function.strtotime.php
         * PHP string time functions
         *
         */
        static function format_date($original, $format=Gloo_Constants::DDMONYYYY) {
            //@todo date time can be expensive, profile please
            if (!isset($original) || is_null($original) || empty($original)) {
                return '';
            }
            $dt = strftime($format, strtotime($original));
            return $dt;
        }

        static function squeeze($input) {
            $input = preg_replace('/\s\s+/', ' ', $input);
            return $input;
        }

        static function isAlphaNumeric($input) {
            //Allow spaces
            $input = preg_replace('/\s+/', '', $input);
            return ctype_alnum($input);
        }
        
        //@todo - even a valid value zero triggers this error
        static function isEmpty($name, $value) {
            if (empty($value)) {
                $message = 'Bad input:: ' . $name . ' is empty or null!';
                trigger_error($message, E_USER_ERROR);
            }
        }

        static function startsWith($Haystack, $Needle) {
            // Recommended version, using strpos
            return strpos($Haystack, $Needle) === 0;
        }

        static function convertBytesIntoKB($bytes) {
            //divide bytes by 1024
            $kb = ceil(($bytes / 1024.00));
            return $kb;
        }

    }

}
?>
