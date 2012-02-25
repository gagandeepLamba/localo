 <?php 
	
   include 'sc-app.inc';
   include($_SERVER['APP_WEB_DIR'] . '/inc/header.inc');
   
   $app_id = "282966715106633";
   $app_secret = "7ce4bb5926f53a727e79c7aba7df0061";
   $my_url = "http://www.3mik.com/callback/fb2.php";
		
   session_start();
   $code = $_REQUEST["code"];

   if(empty($code)) {
     $_SESSION['state'] = md5(uniqid(rand(), TRUE)); //CSRF protection
     $dialog_url = "http://www.facebook.com/dialog/oauth?client_id=" 
       . $app_id . "&redirect_uri=" . urlencode($my_url) ."&state="
       . $_SESSION['state'];

     echo("<script> top.location.href='" . $dialog_url . "'</script>");
   }

   if($_REQUEST['state'] == $_SESSION['state']) {
     $token_url = "https://graph.facebook.com/oauth/access_token?"
       . "client_id=" . $app_id . "&redirect_uri=" . urlencode($my_url)
       . "&client_secret=" . $app_secret . "&code=" . $code;

     $response = @file_get_contents($token_url);
     $params = null;
     parse_str($response, $params);

     $graph_url = "https://graph.facebook.com/me?access_token=".$params['access_token'];

     $user = json_decode(file_get_contents($graph_url));
     echo("Hello from FaceBook - " . $user->name);
	 
   }
   else {
     echo("The state does not match. You may be a victim of CSRF.");
   }

 ?>