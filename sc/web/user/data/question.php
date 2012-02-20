<?php

    //sc/user/data/question.php
    include ('sc-app.inc');
    include($_SERVER['APP_WEB_DIR'] . '/inc/header.inc');
	include($_SERVER['APP_WEB_DIR'] . '/inc/role/user.inc');
    
    use com\indigloo\Util;
	 
	if(is_null($gSessionUser)) {
		$gSessionUser = \com\indigloo\auth\User::getUserInSession();
	}
	
	$questionDao = new \com\indigloo\sc\dao\Question();
    $questionDBRows = $questionDao->getAllOnUserEmail($gSessionUser->email);
	
?>  

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>

       <head><title> Questions asked by <?php echo $gSessionUser->firstName; ?>  </title>
         

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
						<h2> Questions asked by <?php echo $gSessionUser->firstName; ?> </h2>
					</div>
									
					<?php
						foreach($questionDBRows as $questionDBRow) {
							$html = \com\indigloo\sc\html\Question::getLinkView($questionDBRow);
							echo $html ;
					
						}
					?>
				</div>
			</div>
		</div> <!-- container -->
		
        <div id="ft">
            <?php include($_SERVER['APP_WEB_DIR'] . '/inc/site-footer.inc'); ?>
        </div>

    </body>
</html>
