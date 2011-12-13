<?php
namespace com\indigloo\news\controller{

    
    class Post implements INewsController{
        
        function process($params,$options) {
            $file = $_SERVER['APP_WEB_DIR']. '/view/post.php' ;
            
            if(is_null($params) || empty($params))
                trigger_error("Required params is null or empty", E_USER_ERROR);
                
            if(!array_key_exists('shortid',$params))
                trigger_error("Required shortid not found in request params", E_USER_ERROR);
            
            
            if(!array_key_exists('token',$params))
                trigger_error("Required token not found in request params", E_USER_ERROR);
            
            //following variables will be visible in $file as well
            $seoTitle = $params['token'];
            $shortId = $params['shortid'];
            
            ob_start();
            include ($file);
            $buffer = ob_get_contents();
            ob_end_clean();
            echo $buffer;
            
        }
    }
}
?>
