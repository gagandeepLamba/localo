<?php

namespace com\indigloo {


    class Template {

        static function renderArray($theTemplate, $view) {
            $theKeys = array_keys($view);
            foreach($theKeys as $theKey) {
                $token = "{".$theKey."}";
                $theTemplate = str_replace($token,$view[$theKey],$theTemplate);
                            
            }
            return $theTemplate;
      
        }
        
        static function renderObject($theTemplate, $view) {
            
            foreach($view as $member=>$value){
                $token = "{".$member."}";
                $theTemplate = str_replace($token,$value,$theTemplate);
            }
            return $theTemplate;
        }

        static function render($tfile, $view) {
            
            if(empty($view)){
                $message = "No view object defined for template rendering" ;
                trigger_error($message,E_USER_ERROR);
            }
            
            $fp = NULL ;
            
            if(file_exists($tfile)){
                $fp = fopen($tfile,'r');
            } else {
                $message = spritnf("template %s not found \n", $tfile);
                trigger_error($message,E_USER_ERROR);
            }
            
            if($fp){
                $theTemplate = fread($fp,filesize($tfile));
                fclose($fp);
            }
            
            
            $buffer = NULL ;

            if(is_array($view)){
                $buffer =  self::renderArray($theTemplate,$view);
            }else if(is_object($view)){
                $buffer =  self::renderObject($theTemplate,$view);
            }else {
               
                trigger_error('Unknown view type supplied for template',E_USER_ERROR);
            }
            
            return $buffer ;
            
        }
        
    }

}

?>
