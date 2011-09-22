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
				
				<div id="main-menu">
					<ul>
						<li><a class="" href="#"> 120 Jobs </a> | </li>
						<li><a class="green" href="#"> 77500$ </a> | </li>
						<li><a class="red" href="#"> BONUS </a></li>
					</ul>
				</div> <!-- statistics -->

                <!-- grid DIV -->
                <div class="yui3-g">
                    <div class="yui3-u-1-3">
                        <?php include($_SERVER['APP_WEB_DIR'] . '/inc/left-panel.inc'); ?>


                    </div> <!-- left unit -->

                    <div class="yui3-u-2-3">
                        <!-- include opening list -->
                        <div id="main-panel"
                        <?php
                            $openingDao = new webgloo\job\dao\Opening();
                            $rows = $openingDao->getAllRecords();
                            foreach ($rows as $row) {
                                $html = webgloo\job\html\template\Opening::getPublicSummary($row);
                                echo $html;
                            }
                        ?>
                    </div>

                </div> <!-- main unit -->
            </div> <!-- GRID -->


        </div> <!-- bd -->
		


    </div> <!-- body wrapper -->

<div id="footer">
<div class="f-content">
<div id="f-menu" class="floatl">
<ul>
<li><a href="#"> Feedback </a> |</li>
<li><a href="#"> FAQ </a> |</li>
<li><a href="#"> Blog </a></li>
</ul>
</div>
<div id="social" class="floatr">
<a class="fb" href="#Facebook"></a>
<a class="tw" href="#Twitter"></a>
<a class="yt" href="#YouTube"></a>
</div>
<div class="clear"></div>
<div id="copyright"> Copyright © 2011 Your Logo </div>
</div>
</div>


</body>
</html>




