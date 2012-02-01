<?php
    //qa/form/ask.php
    
    include 'sc-app.inc';
    include($_SERVER['APP_WEB_DIR'] . '/inc/header.inc');
    include($_SERVER['APP_WEB_DIR'] . '/inc/auth.inc');
	
    use \com\indigloo\ui\form as Form;
    use \com\indigloo\Constants as Constants ;
    use \com\indigloo\Util as Util ;
    
    if (isset($_POST['save']) && ($_POST['save'] == 'Save')) {
        
		//do not munge form data
        $fhandler = new Form\Handler('web-form-1', $_POST,false);
        $fhandler->addRule('title', 'Title', array('required' => 1, 'maxlength' => 128));
        $fhandler->addRule('tags', 'Tags', array('required' => 1));
        //$fhandler->addRule('location', 'Location', array('required' => 1));
        
        $fvalues = $fhandler->getValues();
        $ferrors = $fhandler->getErrors();
    
        
        if ($fhandler->hasErrors()) {
            $locationOnError = '/qa/share.php' ;
            $gWeb->store(Constants::STICKY_MAP, $fvalues);
            $gWeb->store(Constants::FORM_ERRORS,$fhandler->getErrors());
            
            header("location: " . $locationOnError);
            exit(1);
			
        } else {
            
            $questionDao = new com\indigloo\sc\dao\Note();
			$userDao = new com\indigloo\sc\dao\User();
			$userDBRow = $userDao->getUserInSession();
				   
            $data = $questionDao->create($_POST['entity_type'],
								$fvalues['title'],
                                $fvalues['description'],
                                $fvalues['category'],
                                $userDBRow['location'],
                                $fvalues['tags'],
								'brand',
								$userDBRow['email'],
                                $_POST['links_json'],
                                $_POST['images_json'],
								$fvalues['privacy'],
								$sendDeal,
                                0);
    
            $code = $data['code'];
            
            if ($code == com\indigloo\mysql\Connection::ACK_OK ) {
                $locationOnSuccess = '/';
                header("location: " . $locationOnSuccess);
                
            } else {
                $message = sprintf("DB Error: (code is %d) please try again!",$code);
                $gWeb->store(Constants::STICKY_MAP, $fvalues);
                $gWeb->store(Constants::FORM_ERRORS,array($message));
                $locationOnError = '/qa/share.php' ;
                header("location: " . $locationOnError);
                exit(1);
            }
            
           
        }
        
    }
?>