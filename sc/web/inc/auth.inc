<?php
 
 $userDao = new com\indigloo\sc\dao\User();
 
 if(!$userDao->isAuthenticated()){
        $fwd = '/user/login.php?q='.$_SERVER['REQUEST_URI'];
        header('location: '.$fwd);
        exit ;
  }
  
?>

