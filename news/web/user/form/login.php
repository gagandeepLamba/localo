<?php
    //user/form/register.php
    
    include 'news-app.inc';
    include($_SERVER['APP_WEB_DIR'] . '/inc/header.inc');

    
    use com\indigloo\ui\form as Form;
    use com\indigloo\Constants as Constants ;
    
    if (isset($_POST['login']) && ($_POST['login'] == 'Login')) {
        
        $fhandler = new Form\Handler('web-form-1', $_POST);
        $fhandler->addRule('email', 'Email', array('required' => 1));
        $fhandler->addRule('password', 'Password', array('required' => 1));
        
        $fvalues = $fhandler->getValues();
        $ferrors = $fhandler->getErrors();
    
        
        if ($fhandler->hasErrors()) {
            $locationOnError = '/user/login.php?q='.$_POST['fwd_uri'] ;
            $gWeb->store(Constants::STICKY_MAP, $fvalues);
            $gWeb->store(Constants::FORM_ERRORS,$fhandler->getErrors());
            
            header("location: ".$locationOnError);
            exit(1);
        } else {
           
            $user = new com\indigloo\auth\User();
            $data = $user::login('news_login',
                                $fvalues['email'],
                                $fvalues['password']);
    
            $code = $data['code'];
            
            if ($code > 0 ) {
                header("location: ".$_POST['fwd_uri']);
                
            } else{
                
                $gWeb->store(Constants::STICKY_MAP, $fvalues);
                $gWeb->store(Constants::FORM_ERRORS,array("Error: wrong login or password"));
                $locationOnError = '/user/login.php?q='.$_POST['fwd_uri'] ;
                header("location: ".$locationOnError);
                exit(1);
            }
            
           
        }
    }
?>