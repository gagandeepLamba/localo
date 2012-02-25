<?php
    include ('sc-app.inc');
    include ($_SERVER['APP_WEB_DIR'].'/inc/header.inc');
	require($_SERVER['WEBGLOO_LIB_ROOT'] . '/ext/twitteroauth/twitteroauth.php');
    
	function getUserInfo() {
		
		$twitteroauth = new TwitterOAuth('LK7JnXJMZ67Dp5RzErf1Uw',
										 'KwjH6PeNdJQWX9pWd2P0teCTpKe4q5Rc9kIrmnn4xQ',
										 $_SESSION['oauth_token'],
										 $_SESSION['oauth_token_secret']);
		
		$access_token = $twitteroauth->getAccessToken($_GET['oauth_verifier']); 
		
		
		$_SESSION['access_token'] = $access_token;  
		$user_info = $twitteroauth->get('account/verify_credentials'); 
		
		echo " Dump of user information <br>";
		print_r($user_info);
		
		if(isset($user_info->error)){
			echo "<br> user info has error <br> ";
		}
		else {
			echo " <br> user info is fine <br> ";
		}
   
		// @todo we are done - discard  tokens
		// unset($_SESSION['oauth_token']);
		// unset($_SESSION['oauth_token_secret']);
		
	}
	
	if( !empty($_GET['oauth_verifier']) &&
	    !empty($_SESSION['oauth_token']) &&
		!empty($_SESSION['oauth_token_secret'])){
    
			getUserInfo();
		
	} else {
		
		//log error
		header('Location: /user/twitter-login.php');
	}

?>