<?php
    //qa/answer/form/edit.php
    
    include 'sc-app.inc';
    include($_SERVER['APP_WEB_DIR'] . '/inc/header.inc');
    include($_SERVER['APP_WEB_DIR'] . '/inc/role/user.inc');
	
    use \com\indigloo\ui\form as Form;
    use \com\indigloo\Constants as Constants ;
    use \com\indigloo\Util as Util ;
    use \com\indigloo\Url as Url ;
	
	if(is_null($gSessionUser)) {
		$gSessionUser = \com\indigloo\auth\User::getUserInSession();
	}

    if (isset($_POST['save']) && ($_POST['save'] == 'Save')) {
        
        $fhandler = new Form\Handler('web-form-1', $_POST);
        $fhandler->addRule('answer', 'Answer', array('required' => 1));
        
        $fvalues = $fhandler->getValues();
        $ferrors = $fhandler->getErrors();
		
        if ($fhandler->hasErrors()) {
            $locationOnError = Url::createUrl('/qa/answer/edit.php', array('id' => $fvalues['answer_id'])) ;
            $gWeb->store(Constants::STICKY_MAP, $fvalues);
            $gWeb->store(Constants::FORM_ERRORS,$fhandler->getErrors());
            
            header("location: " . $locationOnError);
            exit(1);
			
        } else {
            
            $answerDao = new com\indigloo\sc\dao\Answer();
							   
            $code = $answerDao->update(
								$fvalues['answer_id'],
								$fvalues['answer']
								);
            
            if ($code == com\indigloo\mysql\Connection::ACK_OK ) {
                $locationOnSuccess = Url::createUrl('/qa/show.php', array('id' => $fvalues['question_id'])) ;
                header("location: " . $locationOnSuccess);
                
            } else {
                $message = sprintf("DB Error: (code is %d) please try again!",$code);
                $gWeb->store(Constants::STICKY_MAP, $fvalues);
                $gWeb->store(Constants::FORM_ERRORS,array($message));
                $locationOnError = Url::createUrl('/qa/answer/edit.php', array('id' => $fvalues['answer_id'])) ;
                header("location: " . $locationOnError);
                exit(1);
            }
            
           
        }
        
    }
?>