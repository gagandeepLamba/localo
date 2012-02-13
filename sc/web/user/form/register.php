<?php
    //sc/user/form/register.php
    
    include 'sc-app.inc';
    include($_SERVER['APP_WEB_DIR'] . '/inc/header.inc');

    
    use com\indigloo\ui\form as Form;
    use com\indigloo\Constants as Constants ;
    
    if (isset($_POST['register']) && ($_POST['register'] == 'Register')) {
        
        $fhandler = new Form\Handler('web-form-1', $_POST);
        $fhandler->addRule('first_name', 'First Name', array('required' => 1, 'maxlength' => 32));
        $fhandler->addRule('last_name', 'Last Name', array('required' => 1, 'maxlength' => 32));
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

            $userName = $fvalues['first_name']. ' '.$fvalues['last_name'];
            \com\indigloo\auth\User::create('sc_user',
								$fvalues['first_name'],
                                $fvalues['last_name'],
								$userName,
                                $fvalues['email'],
                                $fvalues['password']);
    
            $code = $data['code'];
            
            if ($code == com\indigloo\mysql\Connection::ACK_OK ) {
                header("location: / ");

            }else {
                $message = sprintf("DB Error: (code is %d) please try again!",$code);
                $gWeb->store(Constants::STICKY_MAP, $fvalues);
                $gWeb->store(Constants::FORM_ERRORS,array($message));
                 $locationOnError = '/user/register.php' ;
                header("location: " . $locationOnError);
                exit(1);
            }
            
        }
    }
?>