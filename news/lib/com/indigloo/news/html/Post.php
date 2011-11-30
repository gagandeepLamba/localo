<?php

namespace com\indigloo\news\html {

    use com\indigloo\Template as Template;
    use com\indigloo\news\view\Media as MediaView ;
    use com\indigloo\Util as Util ;
    
    class Post {
        
        static function getMainPageSummary($postVO) {
           
		    $html = NULL ;
			$mediaJson = $postVO->mediaJson ;
			
			if(!empty($mediaJson)) {
				$template = $_SERVER['APP_WEB_DIR'].'/fragments/widget/image.tmpl' ;
				$mediaVO = json_decode($mediaJson);
				
				$view = new \stdClass;
				$view = clone $mediaVO;
				
				//change height/width
				$dimensions = Util::getScaledDimensions($view->width,$view->height,510,320);
				$view->height = $dimensions['height'];
				$view->width = $dimensions['width'];
				
				$view->title = $postVO->title ;
				$view->summary = $postVO->summary;
				$view->seoTitle = $postVO->seoTitle ;
				
				//print_r($view); exit ;
				$html = Template::render($template,$view);
				
			}else {
				$template = $_SERVER['APP_WEB_DIR'].'/fragments/widget/text.tmpl' ;
				$html = Template::render($template,$postVO);
			}
			
            return $html ;
            
        }
        
    }
    
}

?>