<?php

use com\indigloo\auth\FormAuthentication;
use com\mik3\Constants;

//pages that need user logon need to include this information
if(!FormAuthentication::tryUserRole()){
    //before doing redirect we need to set $request object in session scope
    // so we can access it from redirected pages
    // we do not know who all will call user role check
    $gWeb->store(Constants::PROTECTED_RESOURCE_URI,$_SERVER['REQUEST_URI']);
     //go to user logon page
    header('location: /user/login.php');
    exit ;
}

?>

