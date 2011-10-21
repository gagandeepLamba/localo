<?php
include 'job-app.inc';
require_once ($_SERVER['APP_CLASS_LOADER']);

$applicationDao = new com\mik3\dao\Application();
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


