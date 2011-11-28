<?php
namespace com\indigloo\news\controller{

    
    class Post implements INewsController{
        
        function process($params,$options) {
            $file = $_SERVER['APP_WEB_DIR']. '/view/post.php' ;
            //following variables will be visible in $file as well
            //@todo - change SEO title into post_id
            $postId = 1 ;
            ob_start();
            include ($file);
            $buffer = ob_get_contents();
            ob_end_clean();
            echo $buffer;
            
        }
    }
}
?>
