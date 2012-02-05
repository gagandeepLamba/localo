<?php

 use com\indigloo\auth\User as User ;
 
 if(User::isAdmin()){
    
    $gSessionUser = User::getUserInSession();
    include($_SERVER['APP_WEB_DIR'].'/inc/toolbar/admin.inc') ;
    
  }elseif (User::isStaff()) {
    
    $gSessionUser = User::getUserInSession();
    include($_SERVER['APP_WEB_DIR'].'/inc/toolbar/staff.inc') ;
    
  }else {
    
    include($_SERVER['APP_WEB_DIR'].'/inc/toolbar/default.inc') ;
  }
  
?>