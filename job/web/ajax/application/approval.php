<?php
    include ('job-app.inc');
    include ($_SERVER['APP_WEB_DIR'] . '/inc/header.inc');
    include ($_SERVER['APP_WEB_DIR'] . '/inc/admin/role.inc');

    sleep(5);
    $applicationId = $_POST['applicationId'];
    $code = $_POST['code'];

    //return received code
    echo " received applicationId = $applicationId , code = $code ";
    

?>

