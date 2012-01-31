<?php

namespace com\indigloo\sc\html {

    use com\indigloo\Template as Template;
    use com\indigloo\Util as Util ;
    
    class Category {
        
        static function get($name,$image,$type='ADD') {
			$template = $_SERVER['APP_WEB_DIR'].'/fragments/widget/category.tmpl' ;
			
			$view = new \stdClass;
			$view->name = $name ;
			$view->image = $image ;
			if($type == 'ADD') {
				$view->linkName = 'Add';
				$view->linkClass = 'add-me';
			} else {
				$view->linkName = 'Remove';
				$view->linkClass = 'remove-me';
			}
			$html = Template::render($template,$view);
			
            return $html ;
			
        }
        
    }
    
}

?>
