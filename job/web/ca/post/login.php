<?php

include ('job-app.inc');
include ($_SERVER['APP_WEB_DIR'] . '/inc/header.inc');

use webgloo\auth\FormAuthentication;
use webgloo\common\ui\form as Form;
use webgloo\job\Constants;

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
            $fhandler->addError("admin logon or password is incorrect!");
            $gWeb->store(Constants::FORM_ERRORS, $fhandler->getErrors());
            $gWeb->store(Constants::STICKY_MAP, $fvalues);
            //set role - depending on code
            header("location: " . $locationOnError);
            exit;
        } else {
            //logon success
            //create redirect uri using saved request object
            //destroy after reading this value
            $lastRequest = $gWeb->find(Constants::LAST_REQUEST, true);
            $locationOnSuccess = '/';
            if (!empty($lastRequest)) {
                $locationOnSuccess = $lastRequest->getAttribute(Constants::LAST_URI);
            }
            //successful logon
            header("location: " . $locationOnSuccess);
        }
    }
}
?>
