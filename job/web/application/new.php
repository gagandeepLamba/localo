<?php
    include 'job-app.inc';
    //set the global variables
    include($_SERVER['APP_WEB_DIR'] . '/inc/header.inc');
    include($_SERVER['APP_WEB_DIR'] . '/inc/user/role.inc');
    
    use com\indigloo\common\Util ;
    use com\indigloo\common\ui\form\Sticky ;
    use com\mik3\Constants ;
    use com\indigloo\auth\FormAuthentication ;

    //incoming parameter check
    $organizationId = $gWeb->getRequestParam('g_org_id');
    Util::isEmpty('organizationId', $organizationId);

    $openingId = $gWeb->getRequestParam('g_opening_id');
    Util::isEmpty('openingId', $openingId);

    $openingDao = new com\mik3\dao\Opening();
    $openingDBRow = $openingDao->getRecordOnId($openingId);

    //check1 /check2
    $openingDao->checkNull($openingDBRow);
    $openingDao->checkActive($openingDBRow);


    $openingHtml = com\mik3\html\template\Opening::getUserSummary($openingDBRow);
    
    //find and destroy sticky map
    $sticky = new Sticky($gWeb->find(Constants::STICKY_MAP,true));
    
    //This method will throw an error
    $userVO = FormAuthentication::getLoggedInUser();
    $userId = $userVO->uuid ;
    //Now get applications already sent by this user

    $applicationDao = new com\mik3\dao\Application();
    $applicationCount = $applicationDao->getCountOnUserAndOpeningId($userId,$openingId);
    
    //There is no navigation to new application if application count >2
    // throw error if someone tries to spoof the URL
    //check3
    $openingDao->checkApplicationCount($applicationCount);
    
    $previousUrl = $gWeb->getPreviousUrl();
    //add current url to stack
    $gWeb->addCurrentUrlToStack();
    
?>



<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>

    <head><title> Application for job - <?php echo $openingDBRow['title']; ?> </title>
        
        <meta http-equiv="content-type" content="text/html; charset=ISO-8859-1" />

        <link rel="stylesheet" type="text/css" href="/css/grids-min.css">
        <link rel="stylesheet" type="text/css" href="/css/style.css">
        <script type="text/javascript" src="/js/jquery-1.6.2.min.js"></script>
        <script type="text/javascript" src="/js/jquery.validate.min.js"></script>
        <!-- facebox
        <link href="/lib/facebox/facebox.css" media="screen" rel="stylesheet" type="text/css"/>
        <script src="/lib/facebox/facebox.js" type="text/javascript"></script> -->
        
        <!-- fancybox -->
        <script type="text/javascript" src="/lib/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
        <link rel="stylesheet" href="/lib/fancybox/jquery.fancybox-1.3.4.css" type="text/css" media="screen" />
        
        
        
        <script type="text/javascript">
            
            $(document).ready(function(){
                //form validator
                $("#web-form1").validate({
                    errorLabelContainer: $("#web-form1 div.error")
                });
                
               //attach fancybox
               $(".fbox").fancybox({
                    'title'             : 'press esc to close',
                    'width'				: '75%',
                    'height'			: '75%',
                    'autoScale'     	: false,
                    'transitionIn'		: 'none',
                    'transitionOut'		: 'none',
                    'type'				: 'iframe'
                });
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
                   
                    <div class="yui3-u-2-3">
                        <div id="content">
                            <div class="fb_top">
                                   <div class="fb_name navy floatl">Send Resume </div>
                               
                                   <div class="clear"></div>
                            </div> <!-- fb_top -->
                             
                            <div class="opening">
                                <!-- include opening details -->
                                <?php echo $openingHtml; ?>

                            </div>
                                    
                            <?php
                                include($_SERVER['APP_WEB_DIR'] . '/inc/form/message.inc');
                                include($_SERVER['APP_WEB_DIR'] . '/application/inc/new-form.inc');
                            ?>

                            
                                    
                        </div> <!-- content -->
                    </div>
                    
                    <div class="yui3-u-1-3">
                        <?php include($_SERVER['APP_WEB_DIR'] . '/inc/sidebar.inc'); ?>
                    </div>
                    
                </div> <!-- GRID -->


            </div> <!-- bd -->

        </div> <!-- body wrapper -->
        
        <div id="ft">
            <?php include($_SERVER['APP_WEB_DIR'] . '/inc/site-footer.inc'); ?>
        </div>
    </body>
</html>
