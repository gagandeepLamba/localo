<?php
    include ('job-app.inc');
    include ($_SERVER['APP_WEB_DIR'] . '/inc/header.inc');

    use webgloo\auth\FormAuthentication;

    $openingId = $gWeb->getRequestParam('g_opening_id');
    webgloo\common\Util::isEmpty('openingId', $openingId);

    $organizationId = $gWeb->getRequestParam('g_org_id');
    webgloo\common\Util::isEmpty('$organizationId', $organizationId);


    $openingDao = new webgloo\job\dao\Opening();
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

        $applicationDao = new webgloo\job\dao\Application();
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
         <!-- app css here -->
        <link rel="stylesheet" type="text/css" href="/css/main.css">
        
    </head>


    <body>

        <?php include($_SERVER['APP_WEB_DIR'] . '/inc/toolbar.inc') ?>

        <div id="body-wrapper">

            <div id="hd">
                <?php include($_SERVER['APP_WEB_DIR'] . '/inc/banner.inc') ?>
            </div>
            <div id="bd">
                <!-- grid DIV -->
                <div class="yui3-g">
                    <div class="yui3-u-5-24">
                        <?php include($_SERVER['APP_WEB_DIR'] . '/inc/left-panel.inc') ?>
                    </div> <!-- left unit -->

                    <div class="yui3-u-19-24">
                        <div id="main-panel">
                            <!-- include opening details -->
                            <?php
                                $html = '' ;
                                $action = true ;

                                if(\webgloo\auth\FormAuthentication::tryAdminRole()){
                                    $action = false ;
                                }

                                $html = webgloo\job\html\template\Opening::getUserDetail($openingDBRow,$applicationCount,$action);
                                echo $html;
                                
                            ?>

                            <!-- applications sent by a user -->

                            <?php if($applicationCount > 0 ) { ?>

                             
                                 <div style="margin-left:20px;"> <h3> Applications &nbsp;(<?php echo $applicationCount ; ?>)</h3>

                                     <?php

                                        foreach($applicationRows as $applicationRow) {
                                            //get vanilla application summary
                                            echo webgloo\job\html\template\Application::getUserSummary2($applicationRow,array());

                                        }
                                    ?>
                                    
                                 </div>
                                 
                             <?php } ?>

                        </div>

                       

                    </div> <!-- main unit -->
                </div> <!-- GRID -->


            </div> <!-- bd -->



        </div> <!-- body wrapper -->

        <div id="ft">
           <?php include($_SERVER['APP_WEB_DIR'].'/inc/site-footer.inc') ?>
        </div>
            
    </body>
</html>




