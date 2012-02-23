<?php

namespace com\indigloo\sc\html {

    use com\indigloo\Template as Template;
    use com\indigloo\sc\view\Media as MediaView ;
    use com\indigloo\Util as Util ;
    
    class User {
        
		private static function getPrivateProfile($userDBRow) {
		    $html = NULL ;
			$view = new \stdClass;
			$template = $_SERVER['APP_WEB_DIR'].'/fragments/user/profile/private.tmpl' ;
			
			
			$view->name = $userDBRow['first_name']. ' '.$userDBRow['last_name'];
			$view->createdOn = Util::formatDBTime($userDBRow['created_on']);
			$view->email = $userDBRow['email'];
			
			$html = Template::render($template,$view);
			
            return $html ;
	

		}

		public static function getPublicProfile($userDBRow) {
			return 'public' ;

		}

        static function getProfile($sessionUser,$userDBRow) {
		    $html = NULL ;
          	//private view needs owner
			if(!is_null($sessionUser) && ($sessionUser->email == $userDBRow['email'])) {
				$html = self::getPrivateProfile($userDBRow);
			} else {
				$html = self::getPublicProfile($userDBRow);

			}
			return $html ;
		  			
        }
		
		static function getQuestionBox($userId, $questionDBRows) {
			
		    $html = NULL ;
			$view = new \stdClass;
			$template = $_SERVER['APP_WEB_DIR'].'/fragments/common/link-box.tmpl' ;
			
			$view->header = 'Questions' ;
			
			$buffer = ' <ul>';
			$link_template = '<li> <a href="/qa/show.php?id={id}" > {name} </a> </li>' ;
			
			foreach($questionDBRows as $questionDBRow) {
				
				$link = str_replace(array("{id}", "{name}"),
									array($questionDBRow['id'], $questionDBRow['title']) ,
									$link_template);
				
				$buffer .= $link ;
			}
			
			$buffer .= "</ul> " ;
			
			$view->links = $buffer ;
			$view->moreLink = '/user/data/question.php';
			
			$html = Template::render($template,$view);
			
            return $html ;
		}
		
		static function getAnswerBox($userId, $answerDBRows) {
			
		    $html = NULL ;
			$view = new \stdClass;
			$template = $_SERVER['APP_WEB_DIR'].'/fragments/common/link-box.tmpl' ;
			
			$view->header = 'Answers' ;
			
			$buffer = ' <ul>';
			$link_template = '<li> <a href="/qa/show.php?id={id}" > {name} </a> </li>' ;
			
			foreach($answerDBRows as $answerDBRow) {
				
				$link = str_replace(array("{id}", "{name}"),
									array($answerDBRow['question_id'], $answerDBRow['title']) ,
									$link_template);
				
				$buffer .= $link ;
			}
			
			$buffer .= "</ul> " ;
			
			$view->links = $buffer ;
			$view->moreLink = '#' ;
			
			$html = Template::render($template,$view);
			
            return $html ;
		}
		
        
    }
    
}

?>
