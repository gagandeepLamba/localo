<?php

    include 'job-app.inc';
    include($_SERVER['APP_WEB_DIR'] . '/inc/header.inc');
    //@todo override default error handler
    include($_SERVER['APP_WEB_DIR'] . '/inc/admin/role.inc');

    use com\indigloo\common\Util;
    use com\indigloo\auth\FormAuthentication;
    
    //extract parameters
    $openingId = $gWeb->getRequestParam('g_opening_id');
    Util::isEmpty('openingId', $openingId);

    $action = $gWeb->getRequestParam('action');
    Util::isEmpty('action', $action);

    $gstatus = $gWeb->getRequestParam('g_status');
    Util::isEmpty('gstatus', $gstatus);

    if(!in_array($action, array('A','C','S','EX2W','EX4W'))) {
        trigger_error("wrong action received for opening!", E_USER_ERROR);
    }
    
    //get organizationId from loggedIn user information
    $adminVO = FormAuthentication::getLoggedInAdmin();
    $openingDao = new com\mik3\dao\Opening();

    //send to DAO
    switch ($action) {
        case 'A' :
        case 'C' :
        case 'S' :
            $openingDao->updateStatus($adminVO->organizationId, $openingId, $action);
            break;
        case 'EX2W' :
            $openingDao->extendLife($adminVO->organizationId, $openingId, 15);
            break;
        case 'EX4W':
            $openingDao->extendLife($adminVO->organizationId, $openingId, 30);
            break;
        default:
            break;
    }

    //go back to dashboard page
    header("location: /opening/list.php?g_status=".$gstatus);
?>
