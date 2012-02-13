<?php

 use \com\indigloo\auth\User as User;
 
 if(User::isAuthenticated()){
    $gSessionUser = User::getUserInSession();
    include($_SERVER['APP_WEB_DIR'].'/inc/toolbar/user.inc') ;

  } else {

    include($_SERVER['APP_WEB_DIR'].'/inc/toolbar/default.inc') ;
  }
  
  
?>