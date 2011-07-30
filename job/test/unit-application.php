<?php
include 'job-app.inc';
require_once ($_SERVER['CLASS_LOADER_FILE']);

$applicationDao = new webgloo\job\dao\Application();
$applicationDao->create(2,
        6,
        1,
        'jha.rajeev@gmail.com',
        'Prateek K',
        'senior engineer with c# experience',
        '888383838',
        'prateek.k@gmail.com',
        'cv blah blah',
        'Citrix india',
        'IIT kanpur'
        );



$rows = $applicationDao->getRecords();
print_r($rows);

?>


