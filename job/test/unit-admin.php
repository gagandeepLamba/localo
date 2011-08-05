<?php
include 'job-app.inc';

$adminDao = new webgloo\job\dao\Admin();
$adminDao->create(1,'John', 'Dunn' , 'admin1@gmail.com' , '12345678', '9886124428','Webgloo Enterprises', 'Online manager');
$rows = $adminDao->getRecords();
print_r($rows);

//use webgloo\job\mysql\Admin ;
//Admin::logonAdmin('admin1@gmail.com', '12345678');

?>


