<?php
    //qa/form/ask.php
    
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
        
		//do not munge form data
        $fhandler = new Form\Handler('web-form-1', $_POST);
        $fhandler->addRule('title', 'Title', array('required' => 1, 'maxlength' => 128));
        $fhandler->addRule('tags', 'Tags', array('required' => 1));
        
		$fhandler->addRule('links_json', 'links_json', array('noprocess' => 1));
		$fhandler->addRule('images_json', 'images_json', array('noprocess' => 1));
		
        $fvalues = $fhandler->getValues();
        $ferrors = $fhandler->getErrors();
		
        if ($fhandler->hasErrors()) {
            $locationOnError = Url::createUrl('/qa/edit.php', array('id' => $fvalues['question_id'])) ;
            $gWeb->store(Constants::STICKY_MAP, $fvalues);
            $gWeb->store(Constants::FORM_ERRORS,$fhandler->getErrors());
            
            header("location: " . $locationOnError);
            exit(1);
			
        } else {
            
            $questionDao = new com\indigloo\sc\dao\Question();
							   
            $code = $questionDao->update(
								$fvalues['question_id'],
								$fvalues['title'],
                                $fvalues['description'],
                                $fvalues['category'],
                                $fvalues['location'],
                                $fvalues['tags'],
                                $_POST['links_json'],
                                $_POST['images_json']);
            
            if ($code == com\indigloo\mysql\Connection::ACK_OK ) {
                $locationOnSuccess = Url::createUrl('/qa/show.php', array('id' => $fvalues['question_id'])) ;
                header("location: " . $locationOnSuccess);
                
            } else {
                $message = sprintf("DB Error: (code is %d) please try again!",$code);
                $gWeb->store(Constants::STICKY_MAP, $fvalues);
                $gWeb->store(Constants::FORM_ERRORS,array($message));
                $locationOnError = Url::createUrl('/qa/edit.php', array('id' => $fvalues['question_id'])) ;
                header("location: " . $locationOnError);
                exit(1);
            }
            
           
        }
        
    }
?>