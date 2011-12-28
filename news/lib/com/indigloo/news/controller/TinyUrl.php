<?php
namespace com\indigloo\news\controller{

    
    class TinyUrl implements INewsController{
        
        function process($params,$options) {
            
            $host = $_SERVER['HTTP_HOST'];
            if(strcasecmp($host,'27ma.in') != 0) {
                //for hosts other than 27ma.in
                // we do not know this url
                $controller = new \com\indigloo\news\controller\Null();
                $controller->process(NULL,NULL);
                exit;
            }
            
            $file = $_SERVER['APP_WEB_DIR']. '/view/post.php' ;
            
            if(is_null($params) || empty($params))
                trigger_error("Required params is null or empty", E_USER_ERROR);
                
            if(!array_key_exists('shortid',$params))
                trigger_error("Required shortid not found in request params", E_USER_ERROR);
            
            $shortId = $params['shortid'];
            $pageURI = \com\indigloo\Url::base().'/'.$shortId ;
            
            ob_start();
            include ($file);
            $buffer = ob_get_contents();
            ob_end_clean();
            echo $buffer;
        }
    }
}
?>