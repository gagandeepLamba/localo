<?php
    include 'job-app.inc';
    //set the global variables
    include($_SERVER['APP_WEB_DIR'] . '/inc/header.inc');
    include($_SERVER['APP_WEB_DIR'] . '/inc/user/role.inc');

    use webgloo\common\Util ;
    use webgloo\common\ui\form\Sticky ;
    use webgloo\job\Constants ;
    use webgloo\auth\FormAuthentication ;

    $organizationId = $gWeb->getRequestParam('g_org_id');
    Util::isEmpty('organizationId', $organizationId);

    $openingId = $gWeb->getRequestParam('g_opening_id');
    Util::isEmpty('openingId', $openingId);

    $openingDao = new webgloo\job\dao\Opening();
    $openingDBRow = $openingDao->getRecordOnId($openingId);
    $openingHtml = webgloo\job\html\template\Opening::getUserSummary($openingDBRow);

    //find and destroy sticky map
    $sticky = new Sticky($gWeb->find(Constants::STICKY_MAP,true));
    //This method will throw an error
    $userVO = FormAuthentication::getLoggedInUser();

    $userId = $userVO->uuid ;
    //Now get applications already sent by this user

    $applicationDao = new webgloo\job\dao\Application();
    $applicationCount = $applicationDao->getCountOnUserAndOpeningId($userId,$openingId);

?>



<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>

    <head><title> Application for job - <?php echo $openingDBRow['title']; ?> </title>
        
        <meta http-equiv="content-type" content="text/html; charset=ISO-8859-1" />

        <link rel="stylesheet" type="text/css" href="/css/grids-min.css">
        <link rel="stylesheet" type="text/css" href="/css/main.css">
        <link rel="stylesheet" type="text/css" href="/css/jquery/flick/jquery-ui-1.8.14.custom.css">
        <!-- app css here -->
        <!-- include any javascript here -->
        <script type="text/javascript" src="/js/jquery-1.6.2.min.js"></script>
        <script type="text/javascript" src="/js/jquery.validate.min.js"></script>
        <!-- jquery UI and css -->

        <script type="text/javascript" src="/js/jquery-ui-1.8.14.custom.min.js"></script>
        <script type="text/javascript" src="/js/main.js"></script>

        <script type="text/javascript">
            
            $(document).ready(function(){
                //form validator
                $("#web-form1").validate({
                    errorLabelContainer: $("#web-form1 div.error")
                });
                
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

                <div class="yui3-g">
                    <div class="yui3-u-5-24">
                        <?php include($_SERVER['APP_WEB_DIR'] . '/inc/left-panel.inc'); ?>
                    </div> <!-- left unit -->
                    <div class="yui3-u-19-24">
                        <div id="main-panel">


                            <div>
                                <!-- include opening details -->
                                <?php echo $openingHtml; ?>

                            </div>

                            <?php
                                if ($applicationCount >= 2) {
                                    echo "&nbsp;warning &dash; Quota of 2 jobs per opening is over!";
                                } else {
                                    include($_SERVER['APP_WEB_DIR'] . '/inc/form/message.inc');
                                    include($_SERVER['APP_WEB_DIR'] . '/application/inc/new-form.inc');
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
