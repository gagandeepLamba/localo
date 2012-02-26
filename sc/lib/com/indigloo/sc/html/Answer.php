<?php

namespace com\indigloo\sc\html {

    use com\indigloo\Template as Template;
    use com\indigloo\sc\view\Media as MediaView ;
    use com\indigloo\Util as Util ;
    
    class Answer {

		static function getSummary($answerDBRow) {
           
		    $html = NULL ;
			$view = new \stdClass;
			$template = $_SERVER['APP_WEB_DIR'].'/fragments/answer/summary.tmpl' ;
			
			
			$view->answer = $answerDBRow['answer'];
			$view->createdOn = Util::formatDBTime($answerDBRow['created_on']);
			$view->userName = $answerDBRow['user_name'] ;
			
			$html = Template::render($template,$view);
			
            return $html ;

		}

        static function getWidget($answerDBRow) {
           
		    $html = NULL ;
			$view = new \stdClass;
			$template = $_SERVER['APP_WEB_DIR'].'/fragments/answer/text.tmpl' ;
			
			
			$view->title = $answerDBRow['title'];
			$view->questionId = $answerDBRow['question_id'];
			$view->answer = $answerDBRow['answer'];
			$view->createdOn = Util::formatDBTime($answerDBRow['created_on']);
			$view->userName = $answerDBRow['user_name'] ;
			
			$html = Template::render($template,$view);
			
            return $html ;
			
        }
        
    }
    
}

?>
