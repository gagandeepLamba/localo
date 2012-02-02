<?php

namespace com\indigloo\sc\dao {

    
    use \com\indigloo\Util as Util ;
    use \com\indigloo\sc\mysql as mysql;
    use \com\indigloo\seo\StringUtil as SeoStringUtil ;
    
    class Note {

		function getOnId($noteId) {
			$row = mysql\Note::getOnId($noteId);
			return $row ;
		}
		
		function getAll($stoken,$ft) {
			$ft = empty($ft) ? 't' : $ft ;
			$filter = '' ;
			
			if(!empty($stoken)) {
				switch($ft) {
					case 'b':
					case 't':
						$filter = "where tags like '%".$stoken."%' " ;
						break ;
					case 'l' :
						$filter = "where location like '%".$stoken."%' " ;
						break ;
					default :
						break ;	
				}
			}
			$rows = mysql\Note::getAll($filter);
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
							   $sendDeal,
							   $timeline) {
			
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
							   $sendDeal,
							   $timeline);
            return $data ;
        }
		
		
		function update($noteId,
						       $title,
                               $description,
                               $category,
                               $location,
                               $tags,
                               $linksJson,
                               $imagesJson,
							   $plevel,
							   $sendDeal,
							   $timeline) {
			
            $seoTitle = SeoStringUtil::convertNameToSeoKey($title);
            $data = mysql\Note::update($noteId,
						       $title,
							   $seoTitle,
                               $description,
                               $category,
                               $location,
                               $tags,
                               $linksJson,
                               $imagesJson,
							   $plevel,
							   $sendDeal,
							   $timeline);
            return $data ;
        }

    }

}
?>
