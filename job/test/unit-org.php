<?php
include 'job-app.inc';
include ($_SERVER['APP_WEB_DIR'].'/inc/header.inc');

$organizationDao = new webgloo\job\dao\Organization();
$organizationDao->create('acme widgets ', 'admin2@gmail.com' , 'www.acme.com' ,'description');

?>


