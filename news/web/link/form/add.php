<?php
    //link/form/add.php
    
    include 'news-app.inc';
    include($_SERVER['APP_WEB_DIR'] . '/inc/header.inc');
    include($_SERVER['WEBGLOO_LIB_ROOT'] . '/ext/recaptchalib.php');
      
    use com\indigloo\ui\form as Form;
    use com\indigloo\Constants as Constants ;
    
    if (isset($_POST['save']) && ($_POST['save'] == 'Save')) {
        
       

        $fhandler = new Form\Handler('web-form-1', $_POST,false);
        $fhandler->addRule('link', 'Link', array('required' => 1));
        
        $fvalues = $fhandler->getValues();
        $ferrors = $fhandler->getErrors();
        
        //captcha code
        $privatekey = "6Ld7Xs0SAAAAACFaXMPbeW-7sD2ugp02v4CD7jVd";
        $resp = recaptcha_check_answer ($privatekey,
                                $_SERVER["REMOTE_ADDR"],
                                $_POST["recaptcha_challenge_field"],
                                $_POST["recaptcha_response_field"]);

        if (!$resp->is_valid) {
            $fhandler->addError("Wrong answer to Captcha! Please try again!");
        }
        
        if ($fhandler->hasErrors()) {
            $locationOnError = '/link/add.php' ;
            $gWeb->store(Constants::STICKY_MAP, $fvalues);
            $gWeb->store(Constants::FORM_ERRORS,$fhandler->getErrors());
            
            header("location: " . $locationOnError);
            exit(1);
            
        } else {
            
            $postDao = new com\indigloo\news\dao\Post();
            $data = $postDao->createLink($fvalues['author'],
                                $fvalues['link'],
                                $fvalues['description']);
    
            $code = $data['code'];
            
            if ($code == com\indigloo\mysql\Connection::ACK_OK ) {
                header("location: /link/thanks.php");
                
            }else {
                
                $message = sprintf("DB Error: (code is %d) please try again!",$code);
                $gWeb->store(Constants::STICKY_MAP, $fvalues);
                $gWeb->store(Constants::FORM_ERRORS,array($message));
                $locationOnError = '/link/add.php' ;
                header("location: " . $locationOnError);
                exit(1);
            }
            
        }
    }
?>