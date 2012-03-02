<?php
    //qa/form/new.php
    
    include 'sc-app.inc';
    include($_SERVER['APP_WEB_DIR'] . '/inc/header.inc');
    include($_SERVER['APP_WEB_DIR'] . '/inc/role/user.inc');
	
	if(is_null($gSessionLogin)) {
		$gSessionLogin = \com\indigloo\sc\auth\Login::getLoginInSession();
	}

    use \com\indigloo\ui\form as Form;
    use \com\indigloo\Constants as Constants ;
    use \com\indigloo\Util as Util ;
    use \com\indigloo\Url as Url ;
   	 
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

            $data = $questionDao->create(
								$title,
                                $fvalues['description'],
                                'location',
                                'tags',
								$gSessionLogin->id,
								$gSessionLogin->name,
                                $_POST['links_json'],
                                $_POST['images_json']);
								
   			$code = $data['code'];

            if ($code == com\indigloo\mysql\Connection::ACK_OK ) {
				$newId = $data['lastInsertId'];
				$location = "/item/$newId" ;
                header("location: /qa/thanks.php?q=".$location );
                
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
