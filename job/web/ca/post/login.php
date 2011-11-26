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

    if ($fhandler->hasErrors()) {
        $locationOnError = '/ca/login.php';
        $gWeb->store(Constants::FORM_ERRORS, $fhandler->getErrors());
        $gWeb->store(Constants::STICKY_MAP, $fvalues);
        //set role - depending on code
        header("location: " . $locationOnError);
        exit;
    } else {

        //no form errors - hit the DB
        $code = FormAuthentication::logonAdmin($fvalues['email'], $fvalues['password']);
        if ($code < 0) {
            $locationOnError = '/ca/login.php';
            $fhandler->addError("wrong email or password. Please try again!");
            $gWeb->store(Constants::FORM_ERRORS, $fhandler->getErrors());
            $gWeb->store(Constants::STICKY_MAP, $fvalues);
            //set role - depending on code
            header("location: " . $locationOnError);
            exit;
        } else {
            //logon success
             $locationOnSuccess = '/opening/list.php';
            header("location: " . $locationOnSuccess);
        }
    }
}
?>
