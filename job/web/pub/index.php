<?php

    include 'job-app.inc';
    include($_SERVER['APP_WEB_DIR'] . '/inc/header.inc');
    //add current url to stack
    $gWeb->addCurrentUrlToStack();
    $config = com\indigloo\common\Configuration::getInstance();
    $siteName = $config->getFarmName();

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
   
<html xmlns="http://www.w3.org/1999/xhtml" id="nojs">


    <head><title> <?php echo $siteName; ?> </title>
        <meta http-equiv="content-type" content="text/html; charset=ISO-8859-1" />
        <link rel="stylesheet" type="text/css" href="/css/grids-min.css">
		<link rel="stylesheet" type="text/css" href="/css/style.css" />

    </head>


    <body>

        <?php include($_SERVER['APP_WEB_DIR'] . '/inc/toolbar.inc'); ?>

        <div id="body-wrapper">

            <div id="hd">
                <?php include($_SERVER['APP_WEB_DIR'] . '/inc/banner.inc'); ?>
            </div>
            <div id="bd">
            	
				<!-- grid DIV -->
				<div class="yui3-g">
				   
			
					<div class="yui3-u-2-3">
						<div id="content">
							<div class="opening">
			
								<?php
									$openingDao = new com\mik3\dao\Opening();
									$rows = $openingDao->getAllRecords();
									foreach ($rows as $row) {
										$html = com\mik3\html\template\Opening::getPublicSummary($row);
										echo $html;
									}
								?>
							</div>
						</div> <!-- content -->
			
					</div> 
					
					<div class="yui3-u-1-3">
					   <?php include($_SERVER['APP_WEB_DIR'] . '/inc/sidebar.inc'); ?>
		   
				   </div>
					
				</div> <!-- grid -->


			</div> <!-- bd -->
		


		</div> <!-- body wrapper -->

		<div id="ft">
			<?php include($_SERVER['APP_WEB_DIR'] . '/inc/site-footer.inc'); ?>
		</div>


</body>
</html>




