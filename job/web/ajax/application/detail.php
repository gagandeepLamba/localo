<?php
include ('job-app.inc');
include ($_SERVER['APP_WEB_DIR'] . '/inc/header.inc');
//@todo include security
//@todo include error processing ..

$applicationId = $gWeb->getRequestParam('g_application_id');
webgloo\common\Util::isEmpty('applicationId', $applicationId);

$applicationDao = new webgloo\job\dao\Application();
$applicationDBRow = $applicationDao->getRecordOnId($applicationId);
$html = webgloo\job\html\template\Application::getDetail($applicationDBRow);

echo $html;

?>

