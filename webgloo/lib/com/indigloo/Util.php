<?php

namespace com\indigloo {


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
        
        function getRandomString($length = 8) {
            $characters = '123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $string = '';

            for ($i = 0; $i < $length; $i++) {
                $string .= $characters[mt_rand(0, strlen($characters) - 1)];
            }

            return $string;
        }

        static function array2nl($arr) {
            //lambda style function
            // Anonymous callback @see create_function() on php.net
            $str = array_reduce($arr, create_function('$a,$b', 'return $a."\n".$b ;'));
            return $str;
        }

        static function stringify($var) {
            $buffer = '';
            
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
        static function formatDBTime($original, $format="%d %b %Y") {

             if (!isset($original) || empty($original)) {
                trigger_error("Empty or Null timestamp supplied to utility function",E_USER_ERROR);
            }
            
            $dt = strftime($format, strtotime($original));
            return $dt;
        }
        
        static function secondsInDBTimeFromNow($original) {

            if (!isset($original) || empty($original)) {
                trigger_error("Empty or Null timestamp supplied to utility function",E_USER_ERROR);
            }

            //calculate base time stamp
            $basets = strtotime("now");
            $ts = strtotime($original);
            $interval = $ts - $basets;
            return $interval;
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
        
        //@todo - scaling is plain wrong - need to fix!
        static function getScaledDimensions($width, $height, $frameWidth, $frameHeight=NULL) {

            if (empty($frameHeight)) {
                //Determine frame height from original aspect ratio
                $frameHeight = ($height / $width) * ($frameWidth);
            }
    
            //first try original dimensions for frame
            $newHeight = $height;
            $newWidth = $width;
    
            //calculate new height/ width using aspect-ratio
            if ($newHeight > $frameHeight) {
                $aspectRatio = ($frameHeight / $newHeight);
                $newHeight = $aspectRatio * $newHeight;
                $newWidth = $aspectRatio * $newWidth;
            }
    
            if ($newWidth > $frameWidth) {
                $aspectRatio = ($frameWidth / $newWidth);
                $newHeight = $aspectRatio * $newHeight;
                $newWidth = $aspectRatio * $newWidth;
            }
    
            //Round up to nearest integer
            $newWidth = floor($newWidth);
            $newHeight = floor($newHeight);
            $dimensions = array('width' => $newWidth, 'height' => $newHeight);
            return $dimensions;
            
        }
    

    }

}
?>
