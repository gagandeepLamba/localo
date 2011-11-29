<?php
namespace com\indigloo\seo{

    /* define all the constants for news application */
    class StringUtil {
        static function convertNameToSeoKey($name) {
            $seoKey = '' ;
            //squeeze extra white spaces
            //example#5 - http://in.php.net/preg_replace
            $name = preg_replace('/\s\s+/', ' ', $name);
            //tokenize on spaces
            $tokens = explode(' ',$name);
    
            if(sizeof($tokens) > 0 ) {
                $dash = '-' ;
                $count = 1 ;
                foreach($tokens as $token) {
                    //put a dash for second token
                    if($count > 1 ) {
                        $seoKey .= $dash ;
                    }
                    $seoKey .= strtolower($token);
                    $count++;
    
                }
            }
            return $seoKey ;
        }

    }
}
?>