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
        <!-- app css here -->
        <link rel="stylesheet" type="text/css" href="/css/style.css">
        <script type="text/javascript" src="/js/jquery-1.6.2.min.js"></script>
       

        <!-- include any javascript here -->
        <script type="text/javascript">

            var applicationObject = {};
            //insert message DIV
            applicationObject.insertMessage = function(applicationId){
                //remove existing message DIV
                $("div#message-"+applicationId).remove();
                //insert after application DIV
                var buffer = '<div class="ajax-toolbar" id="message-' + applicationId +  '"></div>' ;
                $("div#application-"+applicationId).append(buffer);

            };

            applicationObject.postApprovalData = function (postURI,applicationId,code) {
                
                try{
                    //insert message DIV
                    applicationObject.insertMessage(applicationId);
                    //show spinner
                    $("#message-"+applicationId).html('<img src="/css/images/ajax_loader.gif" alt="spinner" />');
                    var dataObj = new Object();
                    dataObj.applicationId = applicationId;
                    dataObj.code = code ;
                    
                    //ajax call start
                    $.ajax({
                        url: postURI ,
                        type: 'POST',
                        dataType: 'html',
                        data : dataObj,
                        timeout: 9000,

                        error: function(XMLHttpRequest, textStatus){
                            $("#message-"+applicationId).html(textStatus);
                        },
                        success: function(html){
                            $("#message-"+applicationId).html(html);
                            //disable approval link after success?
                            
                        }
                    }); //ajax call end
                } catch(ex) {
                    $("#message-"+applicationId).html(ex.toString());
                }
            };

            //attach jquery events
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

                $("a.application-approve-link").live("click", function(event){
                    event.preventDefault();
                    var applicationId = $(this).attr("id");
                    applicationObject.postApprovalData('/ajax/application/approval.php', applicationId,'YES');

                }) ;

                $("a.application-reject-link").live("click", function(event){
                    event.preventDefault();
                    var applicationId = $(this).attr("id");
                    applicationObject.postApprovalData('/ajax/application/approval.php', applicationId,'NO');

                }) ;

                
            });



        </script>




    </head>


    <body>
        <?php include($_SERVER['APP_WEB_DIR'] . '/inc/toolbar.inc'); ?>

        <div id="body-wrapper">

            <div id="hd">
                <!-- no banner -->
            </div>
            <div id="bd">
                
                <div class="yui3-g">
                    
                    <div class="yui3-u-1-3">
                        <?php include($_SERVER['APP_WEB_DIR'] . '/inc/left-panel.inc'); ?>
                    </div>
                    
                    <div class="yui3-u-2-3">
                        <div id="content">
                            <div class="fb_top">
                                <div class="fb_name navy floatl">Total Applications &dash;<?php echo $openingDBRow['application_count'] ; ?> </div>
                            
                                <div class="clear"></div>
                            </div> <!-- fb_top -->
                            
            
                            <div class="opening">
                            
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
                            
                        </div> <!-- content -->
                      
                    </div> 
                </div> <!-- GRID -->


            </div> <!-- bd -->

        </div> <!-- body wrapper -->
        
        <div id="ft">
            <?php include($_SERVER['APP_WEB_DIR'] . '/inc/site-footer.inc'); ?>
        </div>
            

    </body>
</html>




