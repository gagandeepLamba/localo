<?php

    //sc/user/dashboard.php
    include ('sc-app.inc');
    include($_SERVER['APP_WEB_DIR'] . '/inc/header.inc');
    include($_SERVER['APP_WEB_DIR'] . '/inc/role/user.inc');
	
    use com\indigloo\Util as Util;
    use com\indigloo\Url as Url;
    use com\indigloo\Configuration as Config;
    use com\indigloo\ui\form\Sticky;
    use com\indigloo\Constants as Constants;
    use com\indigloo\ui\form\Message as FormMessage;
     
    $sticky = new Sticky($gWeb->find(Constants::STICKY_MAP,true));

	$loginId = Url::tryQueryParam('login_id') ;

	$gSessionLogin = \com\indigloo\sc\auth\Login::tryLoginInSession();

	if(is_null($loginId) && !is_null($gSessionLogin)) {
		$loginId = $gSessionLogin->id ;
	}

	if(is_null($loginId)) {
		trigger_error("Error : NULL login_id on user dashboard",E_USER_ERROR);
	}

	
    $userDao = new \com\indigloo\sc\dao\User() ;
	$userDBRow = $userDao->getOnLoginId($loginId);
	
	//@todo handle NULL userDBRow case
	$qparams = Url::getQueryParams($_SERVER['REQUEST_URI']);

	$ptab = 'active' ;
	$ctab = '';
	$tab = 'inc/post.php';

	if(array_key_exists('tab',$qparams) && $qparams['tab'] == 'comment') {
		$tab = 'inc/comment.php' ;
		$ptab = '' ;
		$ctab = 'active' ;

	}

?>  

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>

       <head><title> 3mik.com - page of <?php echo $userDBRow['first_name']; ?>  </title>
    

        <meta http-equiv="content-type" content="text/html; charset=ISO-8859-1" />
		<link rel="stylesheet" type="text/css" href="/3p/bootstrap/css/bootstrap.css">
        <link rel="stylesheet" type="text/css" href="/css/sc.css">
		<script type="text/javascript" src="/3p/jquery/jquery-1.7.1.min.js"></script>
		<script type="text/javascript" src="/3p/bootstrap/js/bootstrap.js"></script>
		<script>
			$(document).ready(function(){
				
			});

		</script>

       
    </head>

    <body>
		<div class="container">
			<div class="row">
				<div class="span12">
					<?php include($_SERVER['APP_WEB_DIR'] . '/inc/toolbar.inc'); ?>
				</div> 
				
			</div>
			
			<div class="row">
				<div class="span12">
					<?php include($_SERVER['APP_WEB_DIR'] . '/inc/banner.inc'); ?>
				</div>
			</div>
			
			
			<div class="row">
				<div class="span12">
					<div class="page-header">
						<h2> <?php echo $gSessionLogin->name; ?> </h2>
					</div>
					<?php echo \com\indigloo\sc\html\User::getProfile($loginId,$userDBRow) ; ?>
				</div>
			</div>

			<div class="row">
				<div class="span9">
					<div class="mt20">
						<ul class="nav nav-tabs">
						<li class="<?php echo $ptab; ?>"> <a href="/user/dashboard.php?tab=post#post">Posts</a></li>
						<li class="<?php echo $ctab; ?>"> <a href="/user/dashboard.php?tab=comment#comment">Comments</a></li>
						</ul>

						<?php include($tab); ?>
					</div> <!-- wrapper -->

				</div>
			</div>
		</div> <!-- container -->
		
        <div id="ft">
            <?php include($_SERVER['APP_WEB_DIR'] . '/inc/site-footer.inc'); ?>
        </div>

    </body>
</html>
