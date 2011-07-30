<?php
include 'job-app.inc';
use webgloo\auth\FormAuthentication ;
$email1 = 'abcd.123@citrix.com';
$password1 = '2233333' ;
$email2 = 'jha.rajeev@gmail.com';
$password2 = '12345678';

$code = FormAuthentication::logonUser($email1, $password1);
echo " email1 =$email1,  password = $password1, code =  $code \n" ;

$code = FormAuthentication::logonUser($email1, $password2);
echo " email1 =$email1,  password = $password2, code =  $code \n" ;

$code = FormAuthentication::logonUser($email2, $password1);
echo " email1 =$email2,  password = $password1, code =  $code \n" ;

$code = FormAuthentication::logonUser($email2, $password2);
echo " email1 =$email2,  password = $password2, code =  $code \n" ;


?>


