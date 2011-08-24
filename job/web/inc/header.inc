<?php
//application header
//classes should be loaded first or we get incomplete class object errors
// Also, do not output anything in class_loader (apart from errors ) - otherwise you will
// get session header related warnings. Please keep this order.

include($_SERVER['APP_LIB_DIR'] . '/class_loader.inc');
include($_SERVER['APP_WEB_DIR'] . '/inc/session.inc');
include($_SERVER['APP_LIB_DIR'] . '/error.inc');

use webgloo\core\Web  ;

$gWeb = Web::getInstance();
$gWeb->start();

?>

