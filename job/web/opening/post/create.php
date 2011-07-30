<?php

include 'job-app.inc';
include($_SERVER['APP_WEB_DIR'] . '/inc/header.inc');
//check if user has customer admin role or not
include($_SERVER['APP_WEB_DIR'] . '/inc/admin/role.inc');

use webgloo\common\ui\form as Form;

if (isset($_POST['save']) && ($_POST['save'] == 'Save')) {
    $fhandler = new Form\Handler('web-form-1', $_POST);
    $fhandler->addRule('title', 'Title', array('required' => 1, 'maxlength' => 100));
    $fhandler->addRule('bounty', 'Bounty', array('required' => 1, 'maxlength' => 10));
    $fhandler->addRule('skill', 'Required Skills', array('required' => 1));
    $fhandler->addRule('location', 'Location', array('required' => 1, 'maxlength' => 32));

    $fvalues = $fhandler->getValues();
    $ferrors = $fhandler->getErrors();
    
    $locationOnError = '/opening/create.php';
    $locationOnSuccess = '/';
    //$glooWeb->setStickyMap('ca_login_form', $fvalues);

    if ($fhandler->hasErrors()) {
        //$glooWeb->setErrors('ca_login_form', $fhandler->getErrors());
        header("location: " . $locationOnError);
        exit(1);
    } else {
        //push values in DB
        
        $openingDao = new webgloo\job\dao\Opening();
        $openingDao->create($fvalues['organization_id'],
                            $fvalues['organization_name'],
                            $fvalues['created_by'],
                            $fvalues['title'],
                            $fvalues['description'],
                            $fvalues['skill'],
                            $fvalues['bounty'],
                            $fvalues['location']);
        header("location: " . $locationOnSuccess);
    }
}
?>