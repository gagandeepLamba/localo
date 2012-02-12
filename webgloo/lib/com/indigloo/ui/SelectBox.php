<?php

namespace com\indigloo\ui {

    use com\indigloo\core\Web as Web;
    use com\indigloo\Constants as Constants ;
    
    class SelectBox {
        
        
        static function render($name,$rows) {
           
            $buffer = '' ;
            $option = '<option value="{code}"> {display}</option>' ;
            
            foreach($rows as $row) {
                $str = str_replace(array("{code}","{display}") ,
                                   array($row['code'], $row['display']) , $option);
                $buffer = $buffer.$str ;
                                         
            }
                
            $buffer = '<select name="'.$name.'"> '.$buffer. ' </select>' ;
            return $buffer ;
        }

    }
    
}


?>
