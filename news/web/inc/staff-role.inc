<?php
 use com\indigloo\auth\User as Auth ;
 
 if(!Auth::isStaff()){
        $fwd = '/user/login.php?q='.$_SERVER['REQUEST_URI'];
        header('location: '.$fwd);
        exit ;
  }

?>

