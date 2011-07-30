
<?php
//standard application header
//start http session
include($_SERVER['APP_WEB_DIR'] . '/inc/session.inc');
use webgloo\core\Web  ;
use webgloo\job\Constants;

//initialize $web object (together with $request etc)
$gWeb = Web::getInstance();
$gWeb->start();
//set self URI in request
$gWeb->setRequestAttribute(Constants::LAST_URI,$_SERVER['REQUEST_URI']);


?>

