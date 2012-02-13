<?php

namespace com\indigloo\sc\dao {

    
    use \com\indigloo\Util as Util ;
    use \com\indigloo\sc\mysql as mysql;
    use \com\indigloo\seo\StringUtil as SeoStringUtil ;
    
    class Question {

		function getOnId($questionId) {
			$row = mysql\Question::getOnId($questionId);
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
			$rows = mysql\Question::getAll($filter);
			return $rows ;
		}
		
        function create($title,
						$description,
						$category,
						$location,
						$tags,
						$userEmail,
						$userName,
						$linksJson,
						$imagesJson) {
			
            $seoTitle = SeoStringUtil::convertNameToSeoKey($title);
            $code = mysql\Question::create(
								$title,
								$seoTitle,
								$description,
								$category,
								$location,
								$tags,
								$userEmail,
								$userName,
								$linksJson,
								$imagesJson);
            return $code ;
        }
		
		
		function update($questionId,
						$title,
						$description,
						$category,
						$location,
						$tags,
						$linksJson,
						$imagesJson) {
			
            $seoTitle = SeoStringUtil::convertNameToSeoKey($title);
            $code = mysql\Question::update($questionId,
						       $title,
							   $seoTitle,
                               $description,
                               $category,
                               $location,
                               $tags,
                               $linksJson,
                               $imagesJson);
            return $code ;
        }

    }

}
?>
