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

       <!-- include any javascript here -->
        <script type="text/javascript">

            $(document).ready(function(){

                //Attach a live event to removeLink
                // live event is required to attach event to future DOM elements
                $("a.opening-more-link").live("click", function(event){
                    event.preventDefault();
                    var openingId = $(this).attr("id");
                    //show details
                    $("#opening-"+openingId).slideDown("slow");


                }) ;

                  // live event is required to attach event to future DOM elements
                $("a.application-more-link").live("click", function(event){
                    event.preventDefault();
                    var applicationId = $(this).attr("id");
                     //hide summary
                    $("#application-summary-"+applicationId).hide();
                    //show application details
                    $("#application-detail-"+applicationId).slideDown("slow");


                }) ;

                $("a.application-less-link").live("click", function(event){
                    event.preventDefault();
                    var applicationId = $(this).attr("id");
                    //hide details
                    $("#application-detail-"+applicationId).slideUp("slow");
                    //show application summary
                    $("#application-summary-"+applicationId).show();
                }) ;

                //show all shy hide-me containers on document load!
                $(".hide-me").hide();

                //wire up the dialog box

                $("#gui-dialog").dialog({
                    autoOpen: false,
                    modal: true,
                    draggable: false,
                    position: 'center',
                    width: '310px'}) ;

                $("a.approval-form-link").live("click", function(event){
                    event.preventDefault();
                    var applicationId = $(this).attr("id");
                    //post to ajax URL
                    //close dialog box
                    //change indicator style for application
                    
                    var loadURI = "/ajax/application/approval.php?g_application_id=" + applicationId ;
                    if(webgloo.gui.debug){
                        alert(" load application approval form :: id :: " + applicationId);
                    }

                    //load dialog box with content of data URI
                    $("#gui-dialog").load(loadURI);
                    $('#gui-dialog').dialog('option', 'title', "Application Approval Form");
                    $('#gui-dialog').dialog('option', 'width', 510);
                    $('#gui-dialog').dialog('option', 'position', 'center');
                    $('#gui-dialog').dialog('option', 'modal', true);
                    //Buttons for this dialog box
                    $('#gui-dialog').dialog('option', 'buttons',
                    {
                        "Close": function() {
                            $(this).dialog("close");
                            $(this).html("");
                        }

                    });

                    $("#gui-dialog").dialog("open");

                }) ;

                

            });



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
                                    <span class="header"> Applications for <?php echo $openingDBRow['title'] ; ?> (Total&nbsp;<?php echo $openingDBRow['application_count'] ; ?>)</span>
                                </div>
                                    <!-- include opening details -->
                                
                                    <?php
                                        $html = webgloo\job\html\template\Opening::getOrganizationSummary2($openingDBRow);
                                        echo $html;
                                        ?>
                                        
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




