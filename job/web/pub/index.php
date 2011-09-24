<?php

    include 'job-app.inc';
    include($_SERVER['APP_WEB_DIR'] . '/inc/header.inc');
    //add current url to stack
    $gWeb->addCurrentUrlToStack();


?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html xmlns="http://www.w3.org/1999/xhtml" id="nojs">


    <head><title> www.job.com - All the job openings </title>
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
                <div class="yui3-u-1-3">
                    <?php include($_SERVER['APP_WEB_DIR'] . '/inc/left-panel.inc'); ?>
        
                </div> <!-- left unit -->
        
			    <div class="yui3-u-2-3">
				<div id="content">
				    <div class="joblist">
    
                        <?php
                            $openingDao = new webgloo\job\dao\Opening();
                            $rows = $openingDao->getAllRecords();
                            foreach ($rows as $row) {
                                $html = webgloo\job\html\template\Opening::getPublicSummary($row);
                                echo $html;
                            }
                        ?>
					</div>
				</div> <!-- content -->
    
                </div> 
            </div> <!-- grid -->


        </div> <!-- bd -->
		


    </div> <!-- body wrapper -->

<?php include($_SERVER['APP_WEB_DIR'] . '/inc/site-footer.inc'); ?>



</body>
</html>




