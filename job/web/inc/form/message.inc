<?php

use com\indigloo\html\template\Flexy ;
use com\mik3\Constants ;
use com\indigloo\core\Web ;

$view = new stdClass;

$gWeb = Web::getInstance();
$messages = $gWeb->find(Constants::FORM_MESSAGES,true);
$errors = $gWeb->find(Constants::FORM_ERRORS,true);

$view->hasItems = false;
$view->hasMessages = false;
$view->hasErrors = false;

if (!empty($messages)) {
    $view->messages = $messages;
    $view->hasItems = true;
    $view->hasMessages = true;
}

if (!empty($errors)) {
    
    $view->errors = $errors;
    $view->hasItems = true;
    $view->hasErrors = true;
}


$flexy = Flexy::getInstance();
$flexy->compile('/form/message.tmpl');
$message = $flexy->bufferedOutputObject($view);
echo $message;

?>
