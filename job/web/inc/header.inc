<?php
//application header
//classes should be loaded first or we get incomplete class object errors
// Also, do not output anything in class_loader (apart from errors ) - otherwise you will
// get session header related warnings. Please keep this order.


include($_SERVER['APP_CLASS_LOADER']);
include($_SERVER['APP_ROOT_DIR'] . '/htdocs/inc/session.inc');
include($_SERVER['APP_ROOT_DIR'] . '/lib/error.inc');

use com\indigloo\core\Web  ;

$gWeb = Web::getInstance();
$gWeb->start();

?>

