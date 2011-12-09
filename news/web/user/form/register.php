<?php
    //user/form/register.php
    
    include 'news-app.inc';
    include($_SERVER['APP_WEB_DIR'] . '/inc/header.inc');

    
    use com\indigloo\ui\form as Form;
    use com\indigloo\Constants as Constants ;
    
    if (isset($_POST['register']) && ($_POST['register'] == 'Register')) {
        
        $fhandler = new Form\Handler('web-form-1', $_POST);
        $fhandler->addRule('name', 'Name', array('required' => 1, 'maxlength' => 32));
        $fhandler->addRule('email', 'Email', array('required' => 1, 'maxlength' => 64));
        $fhandler->addRule('password', 'Password', array('required' => 1 , 'maxlength' => 32));
        
        $fvalues = $fhandler->getValues();
        $ferrors = $fhandler->getErrors();
    
        
        if ($fhandler->hasErrors()) {
            $locationOnError = '/user/register.php' ;
            $gWeb->store(Constants::STICKY_MAP, $fvalues);
            $gWeb->store(Constants::FORM_ERRORS,$fhandler->getErrors());
            
            header("location: " . $locationOnError);
            exit(1);
        } else {
           
            $user = new com\indigloo\auth\User();
            $data = $user::create('news_login',
                                $fvalues['name'],
                                'last_name',
                                $fvalues['email'],
                                $fvalues['email'],
                                $fvalues['password']);
    
            $code = $data['code'];
            
            if ($code == com\indigloo\mysql\Connection::ACK_OK ) {
                header("location: / ");
            }
            
            if($code == com\indigloo\mysql\Connection::DUPLICATE_KEY ) {
                $gWeb->store(Constants::STICKY_MAP, $fvalues);
                $gWeb->store(Constants::FORM_ERRORS,array("Duplicate error : Did you try an existing email? "));
                $locationOnError = '/user/register.php' ;
                header("location: " . $locationOnError);
                exit(1);
            }
            
           
        }
    }
?>