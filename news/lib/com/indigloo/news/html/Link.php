<?php

namespace com\indigloo\news\html {

    use com\indigloo\Template as Template;
    use com\indigloo\Util as Util ;
    
    class Link {
        
		
		
        static function getSummary($linkDBRow) {
           
		    $html = NULL ;
			$html = $linkDBRow['link'];
            return $html ;
			
        }
        
    }
    
}

?>