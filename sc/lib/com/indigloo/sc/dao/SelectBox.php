<?php

namespace com\indigloo\sc\dao {

    
    use \com\indigloo\Util as Util ;
    use \com\indigloo\sc\mysql as mysql;
    use \com\indigloo\seo\StringUtil as SeoStringUtil ;
    
    class SelectBox {

		function get($name) {
            $rows = mysql\SelectBox::get($name);
            return $rows ;
		}
		
        
    }

}
?>
