<?php

namespace com\indigloo\news\html {

    use com\indigloo\Template as Template;
    use com\indigloo\news\view\Media as MediaView ;
    use com\indigloo\Util as Util ;
    
    class Post {
        
        static function getMainPageSummary($postDBRow) {
            $template = $_SERVER['WEB_TEMPLATE_DIR'].'/post/summary.tmpl' ;
			$html = Template::render($template,$postDBRow);
            return $html ;
            
        }
        
    }
    
}

?>