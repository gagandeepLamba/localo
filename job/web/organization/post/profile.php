<?php

include 'job-app.inc';
include($_SERVER['APP_WEB_DIR'] . '/inc/header.inc');
//check if user has customer admin role or not
include($_SERVER['APP_WEB_DIR'] . '/inc/admin/role.inc');

use webgloo\common\ui\form as Form;
use webgloo\core\Web as web ;
use webgloo\job\Constants;

$gWeb = web::getInstance();

if (isset($_POST['save']) && ($_POST['save'] == 'Save')) {
    $fhandler = new Form\Handler('web-form-1', $_POST);
    $fhandler->addRule('name', 'Name', array('required' => 1, 'maxlength' => 100));
    $fhandler->addRule('website', 'Website', array('required' => 1, 'maxlength' => 100));
    
    $fvalues = $fhandler->getValues();
    $ferrors = $fhandler->getErrors();
    
    $locationOnError = '/organization/profile.php';
    $locationOnSuccess = '/opening/list.php';
    

    if ($fhandler->hasErrors()) {
        
        $gWeb->store(Constants::STICKY_MAP, $fvalues);
        $gWeb->store(Constants::FORM_ERRORS,$fhandler->getErrors());
        header("location: " . $locationOnError);
        
    } else {
        
        //push values in DB
        $oragnizationDao = new webgloo\job\dao\Organization();
        //post raw description
        $oragnizationDao->update(
                $fvalues['organization_id'],
                $fvalues['name'],
                $fvalues['website'],
                $_POST['description']);
        
        header("location: " . $locationOnSuccess);
    }
}
?>