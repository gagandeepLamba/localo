<?php

namespace com\indigloo\sc\dao {

    
    use \com\indigloo\Util as Util ;
    use \com\indigloo\sc\mysql as mysql;
    use \com\indigloo\seo\StringUtil as SeoStringUtil ;
    
    class Note {

		function getAll() {
			$rows = mysql\Note::getAll();
			return $rows ;
		}
		
        function create($type,
						       $title,
                               $description,
                               $category,
                               $location,
                               $tags,
							   $brand,
							   $userId,
                               $linksJson,
                               $imagesJson,
							   $plevel,
							   $sendDeal) {
			
            $seoTitle = SeoStringUtil::convertNameToSeoKey($title);
            $data = mysql\Note::create($type,
							   $title,
                               $seoTitle,
                               $description,
                               $category,
                               $location,
                               $tags,
							   $brand,
							   $userId,
                               $linksJson,
                               $imagesJson,
							   $plevel,
							   $sendDeal);
            return $data ;
        }
		

    }

}
?>
