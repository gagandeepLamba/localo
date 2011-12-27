<?php
namespace com\indigloo\seo{

    class StringUtil {
        static function convertNameToSeoKey($name) {
            
            $seoKey = '' ;
            $name = trim($name);
            $name = str_replace('-', ' ', $name);
            
            //squeeze extra white spaces
            //example#5 - http://in.php.net/preg_replace
            $name = preg_replace('/\s\s+/', ' ', $name);
            
            //tokenize on spaces
            $tokens = explode(' ',$name);
    
            if(sizeof($tokens) > 0 ) {
                $dash = '-' ;
                $count = 1 ;
                foreach($tokens as $token) {
                    
                    //Add a dash before next token
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