<?php

namespace com\indigloo {

    use com\indigloo\Util ;

    class Url {

        //accept an array of param and values and add to
        // this base URI
        static function addQueryParameters($url, $params) {
            //existing params
            $q = self::getQueryParams($url);
            //params values will replace the one in q
            $q2 = array_merge($q, $params);
            $fragment = \parse_url($url, PHP_URL_FRAGMENT);
            $path = \parse_url($url, PHP_URL_PATH);
            $newUrl = self::createUrl($path, $q2, $fragment);
            return $newUrl;
        }

        static function createUrl($path, $params, $fragment=NULL) {
            $count = 0;

            foreach ($params as $name => $value) {
                $prefix = ($count == 0) ? '?' : '&';
                $path = $path . $prefix . $name . '=' . $value;
                $count++;
            }
            if (!empty($fragment)) {
                $path = $path.'#'.$fragment;
            }
            return $path;
        }
        
        static function getQueryParams($url) {
            $query = \parse_url($url, PHP_URL_QUERY);
            $params = array();
            if (empty($query)) {
                return $params;
            } else {
                //found query explode on &
                $q = explode("&", $query);
                foreach ($q as $token) {
                    //break on = to get name value pairs
                    list($name, $value) = explode("=", $token);
                    $params[$name] = $value;
                }
            }

            return $params;
        }

        static function tryUrls($urls) {
            foreach($urls as $url) {
                if(!empty($url)) {
                    return $url ;
                }
            }
            
            \trigger_error('Wrong url input',E_USER_ERROR);
        }


    }

}
?>
