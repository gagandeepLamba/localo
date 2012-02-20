<?php

    //sc/user/dashboard.php
    include ('sc-app.inc');
    include($_SERVER['APP_WEB_DIR'] . '/inc/header.inc');
    include($_SERVER['APP_WEB_DIR'] . '/inc/role/user.inc');
	
    use com\indigloo\Util as Util;
    use com\indigloo\ui\form\Sticky;
    use com\indigloo\Constants as Constants;
    use com\indigloo\ui\form\Message as FormMessage;
     
    $sticky = new Sticky($gWeb->find(Constants::STICKY_MAP,true));
    
	if(is_null($gSessionUser)) {
		$gSessionUser = \com\indigloo\auth\User::getUserInSession();
	}
	
	$userId = $gSessionUser->id ;
    $userDao = new \com\indigloo\sc\dao\User() ;
	$userDBRow = $userDao->getonId($userId);
	
	$questionDao = new \com\indigloo\sc\dao\Question() ;
	$questionDBRows = $questionDao->getLatestOnUserEmail($gSessionUser->email);
	
	$answerDao = new \com\indigloo\sc\dao\Answer() ;
	$answerDBRows = $answerDao->getLatestOnUserEmail($gSessionUser->email);
	
	
?>  

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>

       <head><title> 3mik.com - Account page of <?php echo $userDBRow['first_name']; ?>  </title>
    

        <meta http-equiv="content-type" content="text/html; charset=ISO-8859-1" />
		<link rel="stylesheet" type="text/css" href="/3p/bootstrap/css/bootstrap.css">
        <link rel="stylesheet" type="text/css" href="/css/sc.css">
		<script type="text/javascript" src="/3p/jquery/jquery-1.7.1.min.js"></script>
		<script type="text/javascript" src="/3p/bootstrap/js/bootstrap.js"></script>
		
       
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
				<div class="span8">
					<div class="page-header">
						<h2> Account page of <?php echo $gSessionUser->firstName; ?> </h2>
					</div>
					<div>
						<?php echo \com\indigloo\sc\html\User::getProfile($userDBRow) ; ?>
						<div class="row">
							<div class="span4">
								<?php echo \com\indigloo\sc\html\User::getQuestionBox($userId,$questionDBRows) ;  ?>
							</div>
							<div class="span4">
								<?php echo \com\indigloo\sc\html\User::getAnswerBox($userId,$answerDBRows) ;  ?>
							</div>
						</div> <!-- 1x2 grid -->
					</div>	<!-- content -->
				</div>
			</div>
		</div> <!-- container -->
		
        <div id="ft">
            <?php include($_SERVER['APP_WEB_DIR'] . '/inc/site-footer.inc'); ?>
        </div>

    </body>
</html>
