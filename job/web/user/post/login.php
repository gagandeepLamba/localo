<?php

include ('job-app.inc');
include ($_SERVER['APP_WEB_DIR'] . '/inc/header.inc');

use com\indigloo\auth\FormAuthentication;
use com\indigloo\ui\form as Form;
use com\mik3\Constants;
use com\indigloo\Url ;

if (isset($_POST['login']) && ($_POST['login'] == 'Login')) {

    
    $fhandler = new Form\Handler('web-form-1', $_POST);
    $fhandler->addRule('email', 'Email', array('required' => 1));
    $fhandler->addRule('password', 'Password', array('required' => 1));
    $fvalues = $fhandler->getValues();

    $locationOnError = '/user/login.php';
    
    $code = FormAuthentication::logonUser($fvalues['email'], $fvalues['password']);
    
    if ($code < 0) {
        $fhandler->addError("Wrong email or password. Please try again!");
        $gWeb->store(Constants::FORM_ERRORS, $fhandler->getErrors());
        $gWeb->store(Constants::STICKY_MAP,$fvalues);
        //set role - depending on code
        header("location: " . $locationOnError);
    } else {
        //logon success
        //if we came to login page because we tried to access some protected resource
        // otherwise just go to previous page (from where we clicked login)
        // otherwise go to site main page
        $locationOnSuccess = Url::tryUrls(array($gWeb->find(Constants::PROTECTED_RESOURCE_URI,true),$gWeb->getPreviousUrl(), '/'));
        //successful logon
        header("location: " . $locationOnSuccess);
    }
}
?>