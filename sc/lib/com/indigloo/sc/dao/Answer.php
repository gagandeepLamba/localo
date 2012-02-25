<?php

namespace com\indigloo\sc\dao {

    
    use \com\indigloo\Util as Util ;
    use \com\indigloo\sc\mysql as mysql;
    use \com\indigloo\seo\StringUtil as SeoStringUtil ;
    
    class Answer {

		const EMAIL = "scr1flma";

		function createDBFilter($filter) {
			$map = array(self::EMAIL => mysql\Answer::EMAIL_COLUMN);
			$dbfilter = mysql\Helper::createDBFilter($filter,$map);
			return $dbfilter ;
		}


		function getOnQuestionId($questionId) {
			$rows = mysql\Answer::getOnQuestionId($questionId);
			return $rows ;
		}
		
		function getOnId($answerId) {
			$rows = mysql\Answer::getOnId($answerId);
			return $rows ;
		}

		function getPaged($paginator,$filter=NULL) {
 
			//translate the filter in terms of DB Column
			$params = $paginator->getDBParams();
			$count = $paginator->getPageSize();

			if($paginator->isHome()){
				return $this->getLatest($count,$filter);
				
			} else {
				//convert back to base10
				$dbfilter = $this->createDBFilter($filter);
				$start = $params['start'];
				$direction = $params['direction'];

				if(empty($start) || empty($direction)){
					trigger_error('No start or direction DB params in paginator', E_USER_ERROR);
				}

				$start = base_convert($start,36,10);

				$rows = mysql\Answer::getPaged($start,$direction,$count,$dbfilter);
				return $rows ;
			}
		}

		function getLatest($count,$filter=NULL) {
			$dbfilter = $this->createDBFilter($filter);
			$rows = mysql\Answer::getLatest($count,$dbfilter);
			return $rows ;
		}
		
		function getTotalCount($filter=NULL) {
			$dbfilter = $this->createDBFilter($filter);
			$row = mysql\Answer::getTotalCount($dbfilter);
            return $row['count'] ;
		}


		function update($answerId,$answer) {
			$code = mysql\Answer::update($answerId,$answer) ;
			return $code ;
		}
			
        function create($questionId,
						$answer,
						$userEmail,
						$userName) {
			
            
            $code = mysql\Answer::create(
								$questionId,
								$answer,
								$userEmail,
								$userName);
            return $code ;
        }

    }

}
?>
