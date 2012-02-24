<?php

namespace com\indigloo\sc\dao {

    
    use \com\indigloo\Util as Util ;
    use \com\indigloo\Configuration as Config ;
    use \com\indigloo\sc\mysql as mysql;
    use \com\indigloo\seo\StringUtil as SeoStringUtil ;
    
    class Question {

		function getOnId($questionId) {
			$row = mysql\Question::getOnId($questionId);
			return $row ;
		}
		
		function getLatestOnUserEmail($email) {
			$rows = mysql\Question::getLatestOnUserEmail($email);
			return $rows ;
		}
		
		function getAllOnUserEmail($email) {
			$rows = mysql\Question::getAllOnUserEmail($email);
			return $rows ;
		}

		/*
		 * @params $qparams URL query parameter name value pairs 
		 *
		 */

		function getPaged($paginator) {
 
			$params = $paginator->getDBParams();
			$count = $paginator->getPageSize();

			if($paginator->isHome()){
				return $this->getLatest($count);
				
			} else {
				//convert back to base10
				$start = $params['start'];
				$direction = $params['direction'];

				if(empty($start) || empty($direction)){
					trigger_error('No start or direction DB params in paginator', E_USER_ERROR);
				}

				$start = base_convert($start,36,10);

				$rows = mysql\Question::getPaged($start,$direction,$count);
				return $rows ;
			}
		}

		function getLatest($count) {
			$rows = mysql\Question::getLatest($count);
			return $rows ;
		}
		
		function getTotalCount() {
			$row = mysql\Question::getTotalCount();
            return $row['count'] ;
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
