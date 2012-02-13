<?php

namespace com\indigloo\sc\html {

    use com\indigloo\Template as Template;
    use com\indigloo\Util as Util ;
    
    class Question {
        
        static function getSummary($questionDBRow) {
           
		    $html = NULL ;
			$imagesJson = $questionDBRow['images_json'];
			$images = json_decode($imagesJson);
			
			$view = new \stdClass;
			$view->title = $questionDBRow['title'];
			$view->summary = $questionDBRow['description'];
			$view->id = $questionDBRow['id'];
			
				
			$view->userName = $questionDBRow['user_name'];
			$view->createdOn = Util::formatDBTime($questionDBRow['created_on']);
			$view->tags = $questionDBRow['tags'];
			
			$view->border = 'bbd5' ;

				
			if(sizeof($images) > 0) {
				$view->imageClass = 'alignleft resize' ;
				
				$template = $_SERVER['APP_WEB_DIR'].'/fragments/widget/image.tmpl' ;
				
				/* image stuff */
				$image = $images[0] ;
				
				$view->originalName = $image->originalName;
				$view->bucket = $image->bucket;
				$view->storedName = $image->storeName;
				$view->width = $image->width;
				$view->height = $image->height;
				
				/* image stuff end */
				$html = Template::render($template,$view);
				
			} else {
				
				$template = $_SERVER['APP_WEB_DIR'].'/fragments/widget/text.tmpl' ;
				$html = Template::render($template,$view);
			}
			
            return $html ;
			
        }
        
    }
    
}

?>
