<?php

include 'job-app.inc';
include($_SERVER['APP_WEB_DIR'] . '/inc/header.inc');
//check if user has customer admin role or not
include($_SERVER['APP_WEB_DIR'] . '/inc/admin/role.inc');

use com\indigloo\common\ui\form as Form;
use com\indigloo\core\Web as web ;
use com\mik3\Constants;

$gWeb = web::getInstance();

if (isset($_POST['save']) && ($_POST['save'] == 'Save')) {
    $fhandler = new Form\Handler('web-form-1', $_POST);
    $fhandler->addRule('title', 'Title', array('required' => 1, 'maxlength' => 100));
    //multiple of 100,000 is max for bounty
    $fhandler->addRule('bounty', 'Bounty', array('required' => 1, 'maxlength' => 6));
    $fhandler->addRule('skill', 'Required Skills', array('required' => 1));
    $fhandler->addRule('location', 'Location', array('required' => 1, 'maxlength' => 32));
    $fhandler->addRule('expire_on', 'Valid for', array('required' => 1));
    $fhandler->addRule('min_experience', 'Minimum experience', array('required' => 1));

    
    $fvalues = $fhandler->getValues();
    $ferrors = $fhandler->getErrors();
    
    $locationOnError = '/opening/create.php';
    $locationOnSuccess = '/opening/list.php';
    

    if ($fhandler->hasErrors()) {
        
        $gWeb->store(Constants::STICKY_MAP, $fvalues);
        $gWeb->store(Constants::FORM_ERRORS,$fhandler->getErrors());
        header("location: " . $locationOnError);
        
    } else {
        //push values in DB
        $openingDao = new com\mik3\dao\Opening();
        $openingDao->create($fvalues['organization_id'],
                            $fvalues['organization_name'],
                            $fvalues['created_by'],
                            $fvalues['title'],
                            $fvalues['description'],
                            $fvalues['skill'],
                            $fvalues['bounty'],
                            $fvalues['location'],
                            $fvalues['expire_on'],
                            $fvalues['min_experience'],
                            $fvalues['max_experience']);
        header("location: " . $locationOnSuccess);
    }
}
?>