<?php
include 'job-app.inc';
include($_SERVER['APP_WEB_DIR'] . '/inc/header.inc');
//check if user has customer admin role or not
include($_SERVER['APP_WEB_DIR'] . '/inc/admin/role.inc');

use webgloo\auth\FormAuthentication ;
use webgloo\common\Util ;

//This method will throw an error
$adminVO = FormAuthentication::getLoggedInAdmin();

$openingId = $gWeb->getRequestParam('g_opening_id');
Util::isEmpty('openingId', $openingId);

$openingDao = new webgloo\job\dao\Opening();
$openingDBRow = $openingDao->getRecordOnId($openingId);



?>



<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>

    <head><title> Applications for <?php echo $openingDBRow['title'] ; ?> </title>
        

        <meta http-equiv="content-type" content="text/html; charset=ISO-8859-1" />

       <link rel="stylesheet" type="text/css" href="/css/grids-min.css">
        <link rel="stylesheet" type="text/css" href="/css/jquery/flick/jquery-ui-1.8.14.custom.css">
        <!-- app css here -->
        <link rel="stylesheet" type="text/css" href="/css/main.css">

        <script type="text/javascript" src="/js/jquery-1.6.2.min.js"></script>
        <!-- jquery UI and css -->
        <script type="text/javascript" src="/js/jquery-ui-1.8.14.custom.min.js"></script>
        <script type="text/javascript" src="/js/main.js"></script>

        <script type="text/javascript">

            $(document).ready(function(){

                //create dialog box
                $("#gui-dialog").dialog({
                    autoOpen: false,
                    modal: true,
                    draggable: true,
                    position: 'center',
                    width: '310px'}) ;

                });

                //show on demand


        </script>

        


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

                                <div>
                                 <span class="header"> Applications for <?php echo $openingDBRow['title'] ; ?> </span>
                            </div>
                                <!-- include opening details -->
                                
                                    <?php
                                        $html = webgloo\job\html\template\Opening::getMainSummary($openingDBRow);
                                        echo $html;
                                        ?>

                                        <h3> Applications (Total&nbsp;<?php echo $openingDBRow['application_count'] ; ?>) </h3>

                                        <?php
                                        //applications
                                        $applicationDao = new webgloo\job\dao\Application();
                                        $rows = $applicationDao->getRecords($adminVO->organizationId, $openingId);

                                        foreach ($rows as $row) {

                                            $html = webgloo\job\html\template\Application::getOrganizationSummary($row);
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
            <!-- code for common UI dialog box -->
            <div id="gui-dialog" title="">
                <div id="gui-dialog-results"> </div>
            </div>

    </body>
</html>




