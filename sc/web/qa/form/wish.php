<?php
    //qa/form/wish.php
    
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
        
        $fvalues = $fhandler->getValues();
        $ferrors = $fhandler->getErrors();
    
        
        if ($fhandler->hasErrors()) {
            $locationOnError = '/qa/wish.php' ;
            $gWeb->store(Constants::STICKY_MAP, $fvalues);
            $gWeb->store(Constants::FORM_ERRORS,$fhandler->getErrors());
            
            header("location: " . $locationOnError);
            exit(1);
			
        } else {
            
            $noteDao = new com\indigloo\sc\dao\Note();
			$userDao = new com\indigloo\sc\dao\User();
			$userDBRow = $userDao->getUserInSession();
							   
            $data = $noteDao->create($_POST['entity_type'],
								$fvalues['title'],
                                $fvalues['description'],
                                'category',
                                $userDBRow['location'],
                                'tags',
								'brand',
								$userDBRow['email'],
                                $_POST['links_json'],
                                $_POST['images_json'],
								$fvalues['privacy'],
								0,
                                $fvalues['timeline']);
    
            $code = $data['code'];
            
            if ($code == com\indigloo\mysql\Connection::ACK_OK ) {
                $locationOnSuccess = '/';
                header("location: " . $locationOnSuccess);
                
            } else {
                $message = sprintf("DB Error: (code is %d) please try again!",$code);
                $gWeb->store(Constants::STICKY_MAP, $fvalues);
                $gWeb->store(Constants::FORM_ERRORS,array($message));
                $locationOnError = '/qa/wish.php' ;
                header("location: " . $locationOnError);
                exit(1);
            }
            
           
        }
        
    }
?>