<?php

namespace com\indigloo\news\html {

    use com\indigloo\Template as Template;
    use com\indigloo\Util as Util ;
    
    class Link {
        
		
		
        static function getSummary($linkDBRow,$count) {
            $html = NULL ;
			$view = new \stdClass;
			
            $view->id = $linkDBRow['id'];
            $view->author = $linkDBRow['author'];
            $view->link = $linkDBRow['link'];
            $view->description = $linkDBRow['description'];
            $view->createdOn = Util::formatDBTime($linkDBRow['created_on']);
            
            
            $view->bgclass = ( ($count%2) == 0 )? 'lightyellowbg': '' ;
            
			$template = '/fragments/link/summary.tmpl' ;
			$html = Template::render($template,$view);
			return $html ;
        }
        
    }
    
}

?>
