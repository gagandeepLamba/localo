<?php

namespace com\indigloo\sc\html {

    use com\indigloo\Template as Template;
    use com\indigloo\sc\view\Media as MediaView ;
    use com\indigloo\Util as Util ;
    
    class Answer {
        
        static function getSummary($sessionUser,$answerDBRow) {
           
		    $html = NULL ;
			$view = new \stdClass;
			$template = $_SERVER['APP_WEB_DIR'].'/fragments/answer/text.tmpl' ;
			
			
			$view->answer = $answerDBRow['answer'];
			$view->createdOn = Util::formatDBTime($answerDBRow['created_on']);
			$view->userName = $answerDBRow['user_name'] ;
			$view->editLink = '' ;
			
			if(!is_null($sessionUser) &&  ($sessionUser->email == $answerDBRow['user_email'])) {
				$view->editLink = '<span> <a href="/qa/answer/edit.php?id='.$answerDBRow['id'].'"> Edit</a></span>' ;
			}
			
			$html = Template::render($template,$view);
			
            return $html ;
			
        }
        
    }
    
}

?>
