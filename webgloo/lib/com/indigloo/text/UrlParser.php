<?php
namespace com\indigloo\text{
	
	use com\indigloo\Logger;
	use com\indigloo\Util;
    use com\indigloo\Configuration as Config;
	
    class UrlParser {
		
		/*
		 * Given a choice between quick & Dirty vs. correct, always do the
		 * quick (dirty!) thing in extract function. We want this to be quick
		 * so do not do DOM parsing or try to do proper word breaking etc!
		 * 
		 */
		
		function extract($url) {
			
			$html = file_get_contents($url);
			
			$regex = "/<title>(.+)<\/title>/i";
			preg_match($regex, $html, $matches);
			$title = $matches[1];
			
			$tags = get_meta_tags($url);
			$description = '' ;
			
			
			if(!empty($tags) && array_key_exists('description',$tags)) {
				$description = $tags['description'];
			}
			
			if(empty($description)) {
				/*
				 * forget all the cute heuristics  - does not add anything!
				 * The only sane way would be to run such horrible messes through
				 * an actual renderer like webkit.
				 * @try parsing http://48etikay.com for fun!
				 * 
				 */
				
			}
			
			$images = array();
			
			// fetch images
			$regex = '/<img[^>]*'.'src=[\"|\'](.*)[\"|\']/Ui';
			preg_match_all($regex, $html, $matches, PREG_PATTERN_ORDER);
			$images = $matches[1];
			
			if(sizeof($images) > 10 ) {
				$images = array_splice($images,0,10);
			}
			
			$data = array( 'title' => $title,
						  'description' => $description,
						  'images' => $images);
			
			return $data ;
		}
       
    }
}
?>