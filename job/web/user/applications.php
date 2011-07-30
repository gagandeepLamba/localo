<?php
include 'job-app.inc';
include($_SERVER['APP_WEB_DIR'] . '/inc/header.inc');
//check if user has customer admin role or not
include($_SERVER['APP_WEB_DIR'] . '/inc/user/role.inc');

use webgloo\auth\FormAuthentication ;
use webgloo\common\Util ;

//This method will throw an error
$userVO = FormAuthentication::getLoggedInUser();
$userId = $userVO->uuid ;


?>



<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>

    <head><title> Applications for <?php echo $userVO->email ; ?> </title>
        

        <meta http-equiv="content-type" content="text/html; charset=ISO-8859-1" />

        <link rel="stylesheet" type="text/css" href="http://yui.yahooapis.com/3.3.0/build/cssgrids/grids-min.css">
        <!-- app css here -->
        <link rel="stylesheet" type="text/css" href="/css/main.css">
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
                    </div>
                        <div class="yui3-u-19-24">
                            <div id="main-panel">
                                <!-- include opening details -->
                                     <h3> Applications for <?php echo $userVO->email ; ?></h3>

                                        <?php
                                        //applications
                                        $applicationDao = new webgloo\job\dao\Application();
                                        $rows = $applicationDao->getRecordsOnUserId($userVO->uuid);
                                        
                                        foreach ($rows as $row) {
                                            $html = webgloo\job\html\template\Application::getUserSummary($row);
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




