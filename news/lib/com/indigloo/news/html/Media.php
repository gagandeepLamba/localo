<?php

namespace com\indigloo\news\html {

    use com\indigloo\Template as Template;
    use com\indigloo\news\view\Media as MediaView ;
    use com\indigloo\Util as Util ;
    
    class Media {
        
        static function getPostImageActions($mediaDBRow) {
            $template = $_SERVER['APP_WEB_DIR'].'/fragments/image.tmpl' ;
            $mediaVO = MediaView::create($mediaDBRow);
            //@todo adjust height/width
			$html = Template::render($template,$mediaVO);
            return $html ;
            
        }
        
    }
    
}

?>