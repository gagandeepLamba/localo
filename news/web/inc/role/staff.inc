<?php
 use com\indigloo\auth\User as User ;
 
 if(!User::isStaff()){
      $fwd = '/user/login.php?q='.$_SERVER['REQUEST_URI'];
      header('location: '.$fwd);
      exit ;
  }

?>

