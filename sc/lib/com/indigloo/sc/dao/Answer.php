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
