<?php

include 'job-app.inc';
include($_SERVER['APP_WEB_DIR'] . '/inc/header.inc');
include($_SERVER['APP_WEB_DIR'] . '/inc/user/role.inc');


use webgloo\common\ui\form as Form;

if (isset($_POST['save']) && ($_POST['save'] == 'Save')) {
    
    $fhandler = new Form\Handler('web-form-1', $_POST);
    $fhandler->addRule('cv_name', 'Name', array('required' => 1));
    $fhandler->addRule('cv_email', 'Email', array('required' => 1));
    $fhandler->addRule('cv_phone', 'Phone', array('required' => 1));
    $fhandler->addRule('cv_education', 'Education', array('required' => 1));
    $fhandler->addRule('cv_location', 'Location', array('required' => 1, 'maxlength' => 32));
    //turn on to test sticky + form messages
    //$fhandler->addRule('cv_title', 'Title', array('required' => 1));

    $fvalues = $fhandler->getValues();
    $ferrors = $fhandler->getErrors();
    
    $locationOnError = '/application/new.php?g_opening_id='.$_POST['opening_id'];
    $locationOnSuccess = '/';
    
    
    if ($fhandler->hasErrors()) {
        $gWeb->store('sticky_map', $fvalues);
        $gWeb->store('form_errors',$fhandler->getErrors());
        header("location: " . $locationOnError);
        exit(1);
    } else {
        //push values in DB
        //@todo - after success - attach a TxID to this application
        $applicationDao = new webgloo\job\dao\Application();
        $applicationDao->create($fvalues['organization_id'],
                            $fvalues['opening_id'],
                            $fvalues['user_id'],
                            $fvalues['forwarder_email'],
                            $fvalues['cv_name'],
                            $fvalues['cv_title'],
                            $fvalues['cv_phone'],
                            $fvalues['cv_email'],
                            $fvalues['cv_description'],
                            $fvalues['cv_company'],
                            $fvalues['cv_education'],
                            $fvalues['cv_location'],
                            $fvalues['cv_skill']);
        //Go to success page!
        header("location: " . $locationOnSuccess);
    }
}
?>