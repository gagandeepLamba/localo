<?php
namespace com\indigloo\news\controller{

    
    class Post implements INewsController{
        
        function process($params,$options) {
            $host = $_SERVER['HTTP_HOST'];
            $host = strtolower($host);
            
            //last one is for testing..
            $allowed = array('www.27main.com', '27main.com', 'www.news.com');
            
            if(!in_array($host,$allowed)) {
                $controller = new \com\indigloo\news\controller\Null();
                $controller->process(NULL,NULL);
                exit;
                
            }
                
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
            $pageURI = \com\indigloo\Url::base().'/'.$shortId.'/'.$seoTitle ;
            
            ob_start();
            include ($file);
            $buffer = ob_get_contents();
            ob_end_clean();
            echo $buffer;
            
        }
    }
}
?>
