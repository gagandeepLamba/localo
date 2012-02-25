<?php
    include ('sc-app.inc');
    include ($_SERVER['APP_WEB_DIR'].'/inc/header.inc');
	require($_SERVER['WEBGLOO_LIB_ROOT'] . '/ext/twitteroauth/twitteroauth.php');
    
	
	$twitteroauth = new TwitterOAuth('LK7JnXJMZ67Dp5RzErf1Uw', 'KwjH6PeNdJQWX9pWd2P0teCTpKe4q5Rc9kIrmnn4xQ');
	
	
	$host = "http://".$_SERVER["HTTP_HOST"];
	$callBackUrl = $host .'/callback/twitter.php';
	
	//parameter is the URL we will be redirected to
	$request_token = $twitteroauth->getRequestToken($callBackUrl);
	
	// Saving them into the session
	$_SESSION['oauth_token'] = $request_token['oauth_token'];
	$_SESSION['oauth_token_secret'] = $request_token['oauth_token_secret'];
	
	if($twitteroauth->http_code==200){
		$url = $twitteroauth->getAuthorizeURL($request_token['oauth_token']);
		header('Location: '. $url);
		
	} else {
		echo('Something wrong happened.');
		exit ;
		
	}

?>  
