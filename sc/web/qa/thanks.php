<?php

    include ('sc-app.inc');
    include($_SERVER['APP_WEB_DIR'] . '/inc/header.inc');
    
   
    
?>  

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>

       <head><title> Thank you for submitting a Post</title>
         

        <meta http-equiv="content-type" content="text/html; charset=ISO-8859-1" />

		<link rel="stylesheet" type="text/css" href="/3p/bootstrap/css/bootstrap.css">
		<link rel="stylesheet" type="text/css" href="/css/sc.css">
		
		<script type="text/javascript" src="/3p/jquery/jquery-1.7.1.min.js"></script>
		<script type="text/javascript" src="/3p/bootstrap/js/bootstrap.js"></script>
		 
    </head>

    <body>
		<div class="container mh800">
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
						<h2> Thanks for submitting this post </h2>
					</div>
					
					<div class="well">
						<p class="help-text">
						   <a class="btn btn-primary" href="/">Click here to go back to Home Page </a>
						</p>   
					</div>

				</div>
			</div>
		</div> <!-- container -->

        <div id="ft">
            <?php include($_SERVER['APP_WEB_DIR'] . '/inc/site-footer.inc'); ?>
        </div>

    </body>
</html>
