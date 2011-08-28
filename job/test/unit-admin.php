<?php
include 'job-app.inc';
include ($_SERVER['APP_WEB_DIR'].'/inc/header.inc');

$adminDao = new webgloo\job\dao\Admin();
$adminDao->create(1,'mini myers' , 'admin1@gmail.com' , '12345678', '9886124428','Online manager');
$adminDao->create(2,'maya lewis' , 'admin2@gmail.com' , '12345678', '9886124428','Online manager');
$rows = $adminDao->getRecords(2);
print_r($rows);

//use webgloo\job\mysql\Admin ;
//Admin::logonAdmin('admin1@gmail.com', '12345678');

?>


