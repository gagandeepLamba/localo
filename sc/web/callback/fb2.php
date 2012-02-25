<?php 
	
    include 'sc-app.inc';
	include($_SERVER['APP_WEB_DIR'] . '/inc/header.inc');
   
	use com\indigloo\Util;
	use com\indigloo\Constants as Constants;
	use com\indigloo\Configuration as Config;
	use com\indigloo\ui\form\Message as FormMessage ;
	
    $fbAppId = Config::getInstance()->get_value("facebook.app.id");
    $fbAppSecret = Config::getInstance()->get_value("facebook.app.secret");
	$fbCallback = "http://www.3mik.com/callback/fb2.php";
		
   
	$code = NULL;
	if(array_key_exists('code',$_REQUEST)) {
		$code = $_REQUEST["code"];
	}
	
	$error = NULL ;
	if(array_key_exists('error',$_REQUEST)) {
		$error = $_REQUEST['error'] ;
		$description = $_REQUEST['error_description'] ;
		$message = sprintf(" Facebook returned error :: %s :: %s ",$error,$description);
		$gWeb->store(Constants::FORM_ERRORS,array($messagea));
		FormMessage::render();
		exit(1);
	}
	
	if(empty($code) && empty($error)) {
		
		//new state token
		$stoken = Util::getMD5GUID();
		$gWeb->store("fb_state",$stoken);
		
		$fbDialogUrl = "http://www.facebook.com/dialog/oauth?client_id=" .$fbAppId;
		$fbDialogUrl .= "&redirect_uri=" . urlencode($fbCallback) ."&scope=email&state=".$stoken;
		echo("<script> top.location.href='" . $fbDialogUrl . "'</script>");
		exit ;
	}

	//last state token
	$stoken = $gWeb->find('fb_state',true);
	
	if(!empty($code) && ($_REQUEST['state'] == $stoken)) {
    
		//request to get access token
		$fbTokenUrl = "https://graph.facebook.com/oauth/access_token?client_id=".$fbAppId ;
		$fbTokenUrl .= "&redirect_uri=" . urlencode($fbCallback). "&client_secret=" . $fbAppSecret ;
		$fbTokenUrl .= "&code=" . $code;
		
		$response = @file_get_contents($fbTokenUrl);
		$params = null;
		parse_str($response, $params);

		$graph_url = "https://graph.facebook.com/me?access_token=".$params['access_token'];
		$user = json_decode(file_get_contents($graph_url));
        print_r($user);
	 
	}
	else {
		$message = "Error:: The state does not match. You may be a victim of CSRF.";
		$gWeb->store(Constants::FORM_ERRORS,array($message));
		FormMessage::render();
		exit(1);
    }

 ?>
