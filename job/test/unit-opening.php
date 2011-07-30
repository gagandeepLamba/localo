<?php
include 'job-app.inc';
require_once ($_SERVER['CLASS_LOADER_FILE']);

$openingDao = new webgloo\job\dao\Opening();
$openingDao->create(2,'s.j@indigloo.com' , 'web developer job', 'design description -2 ' , 20000);
$rows = $openingDao->getRecords();
print_r($rows);

?>


