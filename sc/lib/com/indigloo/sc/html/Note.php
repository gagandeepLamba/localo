<?php

namespace com\indigloo\sc\html {

    use com\indigloo\Template as Template;
    use com\indigloo\sc\view\Media as MediaView ;
    use com\indigloo\Util as Util ;
    
    class Note {
        
        static function getSummary($noteDBRow,$style) {
           
		    $html = NULL ;
			$imagesJson = $noteDBRow['images_json'];
			$images = json_decode($imagesJson);
			
			$view = new \stdClass;
			$view->title = $noteDBRow['title'];
			$view->summary = $noteDBRow['description'];
			$view->id = $noteDBRow['id'];
			$view->seoTitle = $noteDBRow['seo_title'];
		
			$tags = explode(" ",$noteDBRow['tags']);
				
			if($noteDBRow['location'] != 'location')
				array_push($tags,$noteDBRow['location']);
			
			if($noteDBRow['category'] != 'category')
				array_push($tags,$noteDBRow['category']);
			
			//time-line
			if(!empty($noteDBRow['timeline']))
				$view->timeline = '(Timeline : '.$noteDBRow['timeline']. ')' ;
			else
				$view->timeline = '' ;
			
			$view->userId = $noteDBRow['user_id'];
			$view->createdOn = $noteDBRow['created_on'];
			
			$strTags = array_reduce($tags, create_function('$a,$b', 'return $a." ".$b ;'));
			$view->tags = $strTags;
				
			switch($style) {
				case 1 :
					$view->border = '' ;
					$view->imageClass = 'aligncenter' ;
					break ;
				case 2:
					
					$view->border = 'bbd5' ;
					$view->imageClass = 'alignleft' ;
					break;
				default:
					trigger_error('Unknown style option', E_USER_ERROR);
					break;
			}
				
			if(sizeof($images) > 0) {
				
				$template = $_SERVER['APP_WEB_DIR'].'/fragments/widget/image.tmpl' ;
				
				/* image stuff */
				$image = $images[0] ;
				
				$view->originalName = $image->originalName;
				$view->bucket = $image->bucket;
				$view->storedName = $image->storeName;
				$view->width = $image->width;
				$view->height = $image->height;
				
				
				$dimensions = Util::getScaledDimensions($view->width,$view->height,250,160);
				$view->height = $dimensions['height'];
				$view->width = $dimensions['width'];
				
				
				/* image stuff end */
				$html = Template::render($template,$view);
				
			} else {
				$view->border = 'bbd5' ;
				$template = $_SERVER['APP_WEB_DIR'].'/fragments/widget/text.tmpl' ;
				$html = Template::render($template,$view);
			}
			
            return $html ;
			
        }
        
    }
    
}

?>
