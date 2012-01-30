<?php

namespace com\indigloo\sc\html {

    use com\indigloo\Template as Template;
    use com\indigloo\sc\view\Media as MediaView ;
    use com\indigloo\Util as Util ;
    
    class Question {
        
        static function getSummary($questionDBRow) {
           
		    $html = NULL ;
			$imagesJson = $questionDBRow['images_json'];
			$images = json_decode($imagesJson);
			
			
			if(sizeof($images) > 0) {

				$template = $_SERVER['APP_WEB_DIR'].'/fragments/widget/image.tmpl' ;
				
				$view = new \stdClass;
				$view->title = $questionDBRow['title'];
				$view->summary = $questionDBRow['description'];
				$view->id = $questionDBRow['id'];
				$view->seoTitle = $questionDBRow['seo_title'];
				
				//use first image
				$image = $images[0] ;
				
				$view->originalName = $image->originalName;
				$view->bucket = $image->bucket;
				$view->storedName = $image->storeName;
				$view->width = $image->width;
				$view->height = $image->height;
				
				//change height/width
				$dimensions = Util::getScaledDimensions($view->width,$view->height,510,320);
				$view->height = $dimensions['height'];
				$view->width = $dimensions['width'];
				
				$html = Template::render($template,$view);
				
			} else {
				
				$template = $_SERVER['APP_WEB_DIR'].'/fragments/widget/text.tmpl' ;
				
				$view = new \stdClass;
				$view->title = $questionDBRow['title'];
				$view->summary = $questionDBRow['description'];
				$view->id = $questionDBRow['id'];
				$view->seoTitle = $questionDBRow['seo_title'];
				
				$html = Template::render($template,$view);
			}
			
            return $html ;
			
        }
        
    }
    
}

?>