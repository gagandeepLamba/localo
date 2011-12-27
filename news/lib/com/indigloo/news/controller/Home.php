<?php
namespace com\indigloo\news\controller{

    use \com\indigloo\ui\Pagination as Pagination;
    use \com\indigloo\Url as Url;
    
    class Home implements INewsController{
        
        function process($params,$options) {
            $pageNo = 1 ;
            if(array_key_exists('pageNo',$params)) {
                $pageNo = $params['pageNo'];
            }
            
            $postDao = new \com\indigloo\news\dao\Post();
            $postDBRows = $postDao->getLatestPostWithMedia();
            $paginator = new Pagination($pageNo);
            
            $file = $_SERVER['APP_WEB_DIR']. '/view/home.php' ;
            ob_start();
            include ($file);
            $buffer = ob_get_contents();
            ob_end_clean();
            echo $buffer;
            
        }
    }
}
?>