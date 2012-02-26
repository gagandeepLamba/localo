<?php
    //sc/user/form/login.php
    
    include 'sc-app.inc';
    include($_SERVER['APP_WEB_DIR'] . '/inc/header.inc');

    
    use com\indigloo\ui\form as Form;
    use com\indigloo\Constants as Constants ;
    
    if (isset($_POST['login']) && ($_POST['login'] == 'Login')) {
        
        $fhandler = new Form\Handler('web-form-1', $_POST);
        $fhandler->addRule('email', 'Email', array('required' => 1, 'maxlength' => 64));
        $fhandler->addRule('password', 'Password', array('required' => 1, 'maxlength' => 32));
        
        $fvalues = $fhandler->getValues();
        $ferrors = $fhandler->getErrors();
        
        $forwardURI = '/' ;
        
        if(array_key_exists('fwd_uri',$_POST) && (!empty($_POST['fwd_uri']))) {
            $forwardURI = $_POST['fwd_uri'] ;
        }
        
        
        if ($fhandler->hasErrors()) {
            $locationOnError = '/user/login.php?q='.$forwardURI ;
            $gWeb->store(Constants::STICKY_MAP, $fvalues);
            $gWeb->store(Constants::FORM_ERRORS,$fhandler->getErrors());
            
            header("location: ".$locationOnError);
            exit(1);
        } else {
            
            $data = \com\indigloo\auth\User::login('sc_user',
                                $fvalues['email'],
                                $fvalues['password']);
            
            $code = $data['code'];
            
            if ($code > 0 ) {
				//success set our own session variables
				\com\indigloo\sc\auth\Login::startMikSession();
                header("location: ".$forwardURI);
                
            } else{
                
                $gWeb->store(Constants::STICKY_MAP, $fvalues);
                $gWeb->store(Constants::FORM_ERRORS,array("Error: wrong login or password"));
                $locationOnError = '/user/login.php?q='.$forwardURI ;
                

                header("location: ".$locationOnError);
                exit(1);
            }
            
           
        }
    }
?>
