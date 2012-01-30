<?php

namespace com\indigloo\sc\dao {

    
    use \com\indigloo\Util as Util ;
    use \com\indigloo\sc\mysql as mysql;
    use \com\indigloo\seo\StringUtil as SeoStringUtil ;
    
    class Question {

		function getAll() {
			$rows = mysql\Question::getAll();
			return $rows ;
		}
		
        function create($title,$description,$category,$location,$tags,$linksJson,
						$imagesJson,$privacy,$sendDeal) {
			
            $seoTitle = SeoStringUtil::convertNameToSeoKey($title);
            $data = mysql\Question::create($title,$seoTitle,$description,$category,
										   $location,$tags,$linksJson,$imagesJson,
										   $privacy,$sendDeal);
            return $data ;
        }
		

    }

}
?>
