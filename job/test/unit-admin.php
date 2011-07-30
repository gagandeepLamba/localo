<?php
include 'job-app.inc';

//$adminDao = new webgloo\job\dao\Admin();
//$adminDao->create(2,'sanjeev', 'Jha' , 'sanjeevnjha@gmail.com' , '12345678', '9886124428','Citrix', 'Online manager');
//$rows = $adminDao->getRecords();
//print_r($rows);

use webgloo\job\mysql\Admin ;

Admin::logonAdmin('sanjeevnjha@gmail.com', '12345678');

?>


