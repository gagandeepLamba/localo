<?php
include ('job-app.inc');
include ($_SERVER['APP_WEB_DIR'] . '/inc/header.inc');
include ($_SERVER['APP_WEB_DIR'] . '/inc/user/role.inc');

//@todo include error processing ..

$applicationId = $gWeb->getRequestParam('g_application_id');
webgloo\common\Util::isEmpty('applicationId', $applicationId);

$applicationDao = new webgloo\job\dao\Application();
$applicationDBRow = $applicationDao->getRecordOnId($applicationId);
$html = webgloo\job\html\template\Application::getUserDetail($applicationDBRow);

echo $html;

?>

