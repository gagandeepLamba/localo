<?php include 'job-app.inc'; ?>
<?php include($_SERVER['APP_WEB_DIR'] . '/inc/header.inc'); ?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>

    <head><title> www.job.com - All the job openings </title>
       

        <meta http-equiv="content-type" content="text/html; charset=ISO-8859-1" />

        <link rel="stylesheet" type="text/css" href="http://yui.yahooapis.com/3.3.0/build/cssgrids/grids-min.css">
        <link rel="stylesheet" type="text/css" href="/css/main.css">
        
        <!-- app css here -->
        <!-- include any javascript here -->


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
                    <div class="yui3-u-5-24">
                        <?php include($_SERVER['APP_WEB_DIR'] . '/inc/left-panel.inc'); ?>


                    </div> <!-- left unit -->

                    <div class="yui3-u-19-24">
                        <!-- include opening list -->
                        <div id="main-panel"
                        <?php
                            $openingDao = new webgloo\job\dao\Opening();
                            $rows = $openingDao->getAllRecords();
                            foreach ($rows as $row) {
                                $html = webgloo\job\html\template\Opening::getUserSummary($row);
                                echo $html;
                            }
                        ?>
                    </div>

                </div> <!-- main unit -->
            </div> <!-- GRID -->


        </div> <!-- bd -->



    </div> <!-- body wrapper -->

    <div id="ft">
        <?php include($_SERVER['APP_WEB_DIR'] . '/inc/site-footer.inc'); ?>
       
    </div>

</body>
</html>




