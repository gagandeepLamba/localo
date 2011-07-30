<?php

use webgloo\auth\FormAuthentication;
use webgloo\job\Constants;

//pages that need user logon need to include this information
if(!FormAuthentication::tryAdminRole()){
    //before doing redirect we need to set $request object in session scope
    // so we can access it from redirected pages
    // we do not know who all will call user role check
    $gWeb->store(Constants::LAST_REQUEST,$gWeb->getRequest());
     //go to user logon page
    header('location: /ca/login.php');
    exit ;
}

?>






