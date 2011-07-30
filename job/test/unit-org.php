<?php
include 'job-app.inc';
require_once ($_SERVER['CLASS_LOADER_FILE']);

$organizationDao = new webgloo\job\dao\Organization();
$organizationDao->create('webgloo', 's.jha@webgloo.com' , 'webgloo.com' ,'webgloo description');

?>


