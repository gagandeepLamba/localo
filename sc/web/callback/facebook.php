<?php
    //sc/user/form/fb-login.php
    
    include 'sc-app.inc';
    include($_SERVER['APP_WEB_DIR'] . '/inc/header.inc');
	echo "test <br>";
	
    
	include($_SERVER['WEBGLOO_LIB_ROOT'] . '/ext/fb-sdk/facebook.php');
    
	$facebook = new Facebook(array(
		'appId'  => '282966715106633',
		'secret' => '7ce4bb5926f53a727e79c7aba7df0061',
	));

	$userId = $facebook->getUser();
	if ($userId) { 
		$userInfo = $facebook->api('/' + $userId);
		
		$userId = $userInfo["id"];
		$name = $userInfo["name"];
		$email = $userInfo["email"];
		$gender = $userInfo["gender"];
		$picture = "http://graph.facebook.com/".$userId."/picture";
		
		echo " <br> FB login success, Hello $name! <br> ";
		echo " <br> Email $email ! <br> ";
		echo " <br> Gender $gender! <br> ";
		
		
	} else {
		echo " FB login is a flop!" ;
		
	}

?>