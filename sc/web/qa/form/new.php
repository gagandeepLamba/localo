<?php
    //qa/form/new.php
    
    include 'sc-app.inc';
    include($_SERVER['APP_WEB_DIR'] . '/inc/header.inc');
    include($_SERVER['APP_WEB_DIR'] . '/inc/role/user.inc');
	
	if(is_null($gSessionUser)) {
		$gSessionUser = \com\indigloo\auth\User::getUserInSession();
	}

    use \com\indigloo\ui\form as Form;
    use \com\indigloo\Constants as Constants ;
    use \com\indigloo\Util as Util ;
    
    if (isset($_POST['save']) && ($_POST['save'] == 'Save')) {
        
        $fhandler = new Form\Handler('web-form-1', $_POST);

        $fhandler->addRule('links_json', 'links_json', array('noprocess' => 1));
		$fhandler->addRule('images_json', 'images_json', array('noprocess' => 1));
		
        $fvalues = $fhandler->getValues();
        $ferrors = $fhandler->getErrors();

		$qUrl = $fvalues['q'];
    
        
        if ($fhandler->hasErrors()) {
            $gWeb->store(Constants::STICKY_MAP, $fvalues);
            $gWeb->store(Constants::FORM_ERRORS,$fhandler->getErrors());
            
            header("location: " . $qUrl);
            exit(1);
			
        } else {
            
            $questionDao = new com\indigloo\sc\dao\Question();
			$title = Util::abbreviate($fvalues['description'],128);		

            $code = $questionDao->create(
								$title,
                                $fvalues['description'],
                                $fvalues['category'],
                                'location',
                                'tags',
								$gSessionUser->email,
								$gSessionUser->firstName,
                                $_POST['links_json'],
                                $_POST['images_json']);
								
    
            if ($code == com\indigloo\mysql\Connection::ACK_OK ) {
                header("location: /qa/thanks.php" );
                
            } else {
                $message = sprintf("DB Error: (code is %d) please try again!",$code);
                $gWeb->store(Constants::STICKY_MAP, $fvalues);
                $gWeb->store(Constants::FORM_ERRORS,array($message));
                header("location: " . $qUrl);
                exit(1);
            }
            
           
        }
        
    }
?>
