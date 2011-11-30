<?php

namespace com\indigloo\news\html {

    use com\indigloo\Template as Template;
    use com\indigloo\news\view\Media as MediaView ;
    use com\indigloo\Util as Util ;
    
    class Post {
        
        static function getMainPageSummary($postDBRow) {
           
		    $html = NULL ;
			$coverMediaId = $postDBRow['s_media_id'];
			
			if(!empty($coverMediaId)) {

				$template = $_SERVER['APP_WEB_DIR'].'/fragments/widget/image.tmpl' ;
				
				$view = new \stdClass;
				$view->title = $postDBRow['title'];
				$view->summary = $postDBRow['summary'];
				$view->seoTitle = $postDBRow['seo_title'];
				
				$view->originalName = $postDBRow['original_name'];
				$view->bucket = $postDBRow['bucket'];
				$view->storedName = $postDBRow['stored_name'];
				
				$view->width = $postDBRow['original_width'];
				$view->height = $postDBRow['original_height'];
				
				//change height/width
				$dimensions = Util::getScaledDimensions($view->width,$view->height,510,320);
				$view->height = $dimensions['height'];
				$view->width = $dimensions['width'];
				
				//print_r($view); exit ;
				$html = Template::render($template,$view);
				
			}else {
				$template = $_SERVER['APP_WEB_DIR'].'/fragments/widget/text.tmpl' ;
				
				$view = new \stdClass;
				$view->title = $postDBRow['title'];
				$view->summary = $postDBRow['summary'];
				$view->seoTitle = $postDBRow['seo_title'];
				
				$html = Template::render($template,$view);
			}
			
            return $html ;
			
        }
        
    }
    
}

?>