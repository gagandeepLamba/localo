<?php

    //sc/index
    include ('sc-app.inc');
    include($_SERVER['APP_WEB_DIR'] . '/inc/header.inc');
    
    use com\indigloo\Util;
    use com\indigloo\Url;
    use com\indigloo\ui\form\Sticky;
    use com\indigloo\Constants as Constants;
    use com\indigloo\ui\form\Message as FormMessage;
	use \com\indigloo\Configuration as Config ;
  
    $sticky = new Sticky($gWeb->find(Constants::STICKY_MAP,true));

	$questionDao = new \com\indigloo\sc\dao\Question();
	$total = $questionDao->getTotalCount();

	$qparams = Url::getQueryParams($_SERVER['REQUEST_URI']);
	$pageSize =	$count = Config::getInstance()->get_value("main.page.items");
	$paginator = new \com\indigloo\ui\Pagination($qparams,$total,$pageSize);	

    $questionDBRows = $questionDao->getPaged($paginator);
	
?>  

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>

       <head><title> 3mik.com - Home page  </title>
         

        <meta http-equiv="content-type" content="text/html; charset=ISO-8859-1" />

        <link rel="stylesheet" type="text/css" href="/3p/bootstrap/css/bootstrap.css">
        <link rel="stylesheet" type="text/css" href="/css/sc.css">
		<script type="text/javascript" src="/3p/jquery/jquery-1.7.1.min.js"></script>
		<script type="text/javascript" src="/3p/bootstrap/js/bootstrap.js"></script>
		<script type="text/javascript" src="/3p/jquery/masonary/jquery.masonry.min.js"></script>
	    
		
		<script type="text/javascript">
			/* column width = css width + margin */
			$(document).ready(function(){
				var $container = $('#tiles');
				$container.imagesLoaded(function(){
					$container.masonry({
						itemSelector : '.tile'
						
					});
				});
			});
		</script>
		
    </head>

     <body class="dark-body">
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
				<div class="span11">
					<div id="tiles">
						<?php

							$startId = NULL ;
							$endId = NULL ;	

							if(sizeof($questionDBRows) > 0 ) { 
								$startId = $questionDBRows[0]['id'] ;
								$endId =   $questionDBRows[sizeof($questionDBRows)-1]['id'] ;
							}	

							foreach($questionDBRows as $questionDBRow) {
								$html = \com\indigloo\sc\html\Question::getSummary($questionDBRow);
								echo $html ;
						
							}
						?>
						   
					</div><!-- tiles -->

					<?php $paginator->render('/',$startId,$endId);  ?>

				</div> 
				<div class="span1">
					<div id="feedback" class="vertical">
						<a href="/share/feedback.php">
							Y O U R    
							<br />
							<br />
						    F E E D B A C K 	
						</a>
					</div>	

				</div>
			</div>
			
			
		</div>  <!-- container -->
              
       
        <div id="ft">
            <?php include($_SERVER['APP_WEB_DIR'] . '/inc/site-footer.inc'); ?>
        </div>

    </body>
</html>
