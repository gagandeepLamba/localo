<?php
    include ('job-app.inc');
    include ($_SERVER['APP_WEB_DIR'] . '/inc/header.inc');

    use com\indigloo\auth\FormAuthentication;

    $openingId = $gWeb->getRequestParam('g_opening_id');
    com\indigloo\Util::isEmpty('openingId', $openingId);

    $organizationId = $gWeb->getRequestParam('g_org_id');
    com\indigloo\Util::isEmpty('$organizationId', $organizationId);


    $openingDao = new com\mik3\dao\Opening();
    $openingDBRow = $openingDao->getRecordOnId($openingId);
    
    //sanity checks
    $openingDao->checkNull($openingDBRow);
    $openingDao->checkActive($openingDBRow);


    $applicationRows = array();
    $applicationCount = 0 ;

    if(FormAuthentication::tryUserRole()) {
        //This method will throw an error
        $userVO = FormAuthentication::getLoggedInUser();
        $userId = $userVO->uuid ;
        //Now get applications already sent by this user

        $applicationDao = new com\mik3\dao\Application();
        $applicationRows = $applicationDao->getRecordsOnUserAndOpeningId($userId,$openingId);
        $applicationCount = sizeof($applicationRows);

    }

    //add current url to stack
    $gWeb->addCurrentUrlToStack();
    
?>



<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>

    <head><title> <?php echo $openingDBRow['title']; ?> </title>

        <meta http-equiv="content-type" content="text/html; charset=ISO-8859-1" />
        <link rel="stylesheet" type="text/css" href="/css/grids-min.css">
        <link rel="stylesheet" type="text/css" href="/css/style.css">
        
    </head>


    <body>

        <?php include($_SERVER['APP_WEB_DIR'] . '/inc/toolbar.inc') ?>

        <div id="body-wrapper">

            <div id="hd">
                <!-- no banner -->
            </div>
            <div id="bd">
                <!-- grid DIV -->
                <div class="yui3-g">
                  

                    <div class="yui3-u-2-3">
                        <div id="content">
                            <div class="opening">
                                <!-- include opening details -->
                                <?php
                                    $html = '' ;
                                    $action = true ;
    
                                    if(\com\indigloo\auth\FormAuthentication::tryAdminRole()){
                                        $action = false ;
                                    }
    
                                    $html = com\mik3\html\template\Opening::getUserDetail($openingDBRow,$applicationCount,$action);
                                    echo $html;
                                    
                                ?>
                            </div>
                            
                            <!-- applications sent by a user -->

                            <?php if($applicationCount > 0 ) { ?>
                                    
                                    <div class="opening">
                                    <h4> Applications &nbsp;(<?php echo $applicationCount ; ?>)</h4> 

                                     <?php

                                        foreach($applicationRows as $applicationRow) {
                                            //get vanilla application summary
                                            echo com\mik3\html\template\Application::getUserSummary2($applicationRow,array());

                                        }
                                    ?>
                                    
                                    </div>
                                    
                                 
                             <?php } ?>

                        </div> <!-- content -->

                    </div> 
                    
                    <div class="yui3-u-1-3">
                        <?php include($_SERVER['APP_WEB_DIR'] . '/inc/sidebar.inc') ?>
                    </div> <!-- u-1-3 -->
                    
                </div> <!-- GRID -->


            </div> <!-- bd -->



        </div> <!-- body wrapper -->
        
       <div id="ft">
            <?php include($_SERVER['APP_WEB_DIR'] . '/inc/site-footer.inc'); ?>
        </div>
       
            
    </body>
</html>




