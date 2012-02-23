<?php

namespace com\indigloo\sc\dao {

    
    use \com\indigloo\Util as Util ;
    use \com\indigloo\sc\mysql as mysql;
    use \com\indigloo\seo\StringUtil as SeoStringUtil ;
    
    class Answer {

		function getOnQuestionId($questionId) {
			$rows = mysql\Answer::getOnQuestionId($questionId);
			return $rows ;
		}
		
		function getOnId($answerId) {
			$rows = mysql\Answer::getOnId($answerId);
			return $rows ;
		}
		
		function update($answerId,$answer) {
			$code = mysql\Answer::update($answerId,$answer) ;
			return $code ;
		}
		
		function getLatestOnUserEmail($email) {
			$rows = mysql\Answer::getLatestOnUserEmail($email);
			return $rows ;
		}
	
		function getAllOnUserEmail($email) {
			$rows = mysql\Answer::getAllOnUserEmail($email);
			return $rows ;
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
