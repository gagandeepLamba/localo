<?php
namespace com\indigloo\news\controller{

    
    class Home implements INewsController{
        
        function process($params,$options) {
            $pageNo = 1 ;
            if(array_key_exists('pageNo',$params)) {
                $pageNo = $params['pageNo'];
            }
            
            $postDao = new \com\indigloo\news\dao\Post();
            $postDBRows = $postDao->getLatestRecords();
            //find total number of pages
            $totalPages = $postDao->getTotalPages();
            $paginator = new \com\indigloo\ui\Pagination($pageNo,$totalPages);
            
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