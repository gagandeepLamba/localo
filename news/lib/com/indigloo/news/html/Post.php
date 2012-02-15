<?php

namespace com\indigloo\news\html {

    use com\indigloo\Template as Template;
    use com\indigloo\news\view\Media as MediaView ;
    use com\indigloo\Util as Util ;
    
    class Post {
        
		static function getEditPostButton($row){
			$html = NULL ;
			$view = new \stdClass;
			$view->postId = $row['id'];
			$template = $_SERVER['APP_WEB_DIR'].'/fragments/post/admin-toolbar.tmpl' ;
			$html = Template::render($template,$view);
			return $html ;
		}
		
        static function getMainPageSummary($postDBRow) {
           
		    $html = NULL ;
			$imagesJson = $postDBRow['images_json'];
			$images = json_decode($imagesJson);
			
			$view = new \stdClass;
			$view->title = $postDBRow['title'];
			$view->summary = $postDBRow['summary'];
			$view->shortId = $postDBRow['short_id'];
			$view->seoTitle = $postDBRow['seo_title'];
			
			$view->author = $postDBRow['user_name'];
			$view->createdOn = \com\indigloo\Util::formatDBTime($postDBRow['created_on']);
			
			if(sizeof($images) > 0) {
				
				$template = $_SERVER['APP_WEB_DIR'].'/fragments/widget/image.tmpl' ;
				
				//use first image
				$image = $images[0] ;
				
				$view->originalName = $image->originalName;
				$view->bucket = $image->bucket;
				$view->storedName = $image->storeName;
				$view->width = $image->width;
				$view->height = $image->height;
				
				//change height/width
				$dimensions = Util::foldXY($view->width,$view->height,510,320);
				$view->height = $dimensions['height'];
				$view->width = $dimensions['width'];
				
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