<?php

include 'job-app.inc';
include($_SERVER['APP_WEB_DIR'] . '/inc/header.inc');
include($_SERVER['APP_WEB_DIR'] . '/inc/user/role.inc');


use webgloo\common\ui\form as Form;

if (isset($_POST['save']) && ($_POST['save'] == 'Save')) {
    
    print_r($_POST);
}
?>