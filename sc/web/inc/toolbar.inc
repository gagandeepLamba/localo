<?php

 $userDao = new com\indigloo\sc\dao\User();
 
 if($userDao->isAuthenticated()){
    $userDBRow = $userDao->getUserInSession();
    include($_SERVER['APP_WEB_DIR'].'/inc/toolbar/user.inc') ;
    
  } else {
    include($_SERVER['APP_WEB_DIR'].'/inc/toolbar/default.inc') ;
  }
  
  
?>