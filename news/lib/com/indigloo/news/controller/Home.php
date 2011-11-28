<?php
namespace com\indigloo\news\controller{

    
    class Home implements INewsController{
        
        function process($params,$options) {
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
