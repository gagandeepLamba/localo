<?php
include 'job-app.inc';

$organizationDao = new webgloo\job\dao\Organization();
$organizationDao->create('webgloo', 'admin1@gmail.com' , 'webgloo.com' ,'webgloo description');

?>


