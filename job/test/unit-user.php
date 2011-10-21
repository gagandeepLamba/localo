<?php
include 'job-app.inc';

$userDao = new com\mik3\dao\User();
$userDao->create('Rajeev', 'Jha' , 'jha.rajeev@gmail.com' , '12345678', '9886124428','Citrix', 'Engineering manager');
$rows = $userDao->getRecords();
print_r($rows);

?>


