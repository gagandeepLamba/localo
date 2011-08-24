<?php

include ('job-app.inc');
include ($_SERVER['APP_WEB_DIR'] . '/inc/header.inc');

use webgloo\auth\FormAuthentication;
use webgloo\common\ui\form as Form;
use webgloo\job\Constants;
use webgloo\common\Url ;

if (isset($_POST['register']) && ($_POST['register'] == 'Register')) {
    
    $fhandler = new Form\Handler('web-form-1', $_POST);

    $fhandler->addRule('email', 'Email', array('required' => 1));
    $fhandler->addRule('password', 'Password', array('required' => 1, 'minlength' => 8));
    $fhandler->addRule('name', 'Name', array('required' => 1));
    
    $fvalues = $fhandler->getValues();

    $locationOnError = '/user/register.php';
    $locationOnSuccess = Url::tryUrls(array($gWeb->find(Constants::PROTECTED_RESOURCE_URI,true),$gWeb->getPreviousUrl(), '/'));
    //try to create this user
    $userDao = new webgloo\job\dao\User();
    $dbCode = $userDao->create($fvalues['name'], $fvalues['email'],$fvalues['password']);
    
    if ($dbCode == webgloo\common\mysql\Connection::ACK_OK) {
        //user created
        //log in this user please!
        $logonCode = FormAuthentication::logonUser($fvalues['email'], $fvalues['password']);
        if($logonCode < 1 ) {
            trigger_error('New user cannot log in', E_USER_ERROR);
        }
        
        //go back to main page
        header("location: ".$locationOnSuccess );
        
    } else if ($dbCode == webgloo\common\mysql\Connection::DUPLICATE_KEY) {
        //this user already exists
        $fhandler->addError("Duplicate key error: User with same email already exists!");
        $gWeb->store(Constants::FORM_ERRORS, $fhandler->getErrors());
        $gWeb->store(Constants::STICKY_MAP, $fvalues);
        //set role - depending on code
        header("location: " . $locationOnError);
    } else {
        $fhandler->addError("Unknown database error!");
        $gWeb->store(Constants::FORM_ERRORS, $fhandler->getErrors());
        $gWeb->store(Constants::STICKY_MAP, $fvalues);
        //set role - depending on code
        header("location: " . $locationOnError);
    }
}
?>