<?php
    include 'job-app.inc';
    include($_SERVER['APP_WEB_DIR'] . '/inc/header.inc');
    //check if user has customer admin role or not
    include($_SERVER['APP_WEB_DIR'] . '/inc/admin/role.inc');

    use com\indigloo\auth\FormAuthentication ;
    use com\indigloo\common\Util ;

    //This method will throw an error
    $adminVO = FormAuthentication::getLoggedInAdmin();

    $openingId = $gWeb->getRequestParam('g_opening_id');
    Util::isEmpty('openingId', $openingId);

    $openingDao = new com\mik3\dao\Opening();
    $openingDBRow = $openingDao->getRecordOnId($openingId);



?>



<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>

    <head><title> Applications for <?php echo $openingDBRow['title'] ; ?> </title>
        

        <meta http-equiv="content-type" content="text/html; charset=ISO-8859-1" />

       <link rel="stylesheet" type="text/css" href="/css/grids-min.css">
        
        <link rel="stylesheet" type="text/css" href="/css/style.css">
        <script type="text/javascript" src="/js/jquery-1.6.2.min.js"></script>
        <script type="text/javascript" src="/js/main.js"></script>

        <!-- include any javascript here -->
        <script type="text/javascript">

           //attach jquery events
            $(document).ready(function(){

                applicationObject.attachEvents();
                applicationObject.debug = false ;
                //hide all shy containers on document load!
                $(".hide-me").hide();

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
                                <div class="fb_name navy floatl">Total Applications &dash;<?php echo $openingDBRow['application_count'] ; ?> </div>
                            
                                <div class="clear"></div>
                            </div> <!-- fb_top -->
                            
            
                            <div class="opening">
                            
                                <?php
                                    $html = com\mik3\html\template\Opening::getOrganizationSummary2($openingDBRow);
                                    echo $html;
                                    ?>
                                    
                                    <?php
                                        //applications
                                        $applicationDao = new com\mik3\dao\Application();
                                        $rows = $applicationDao->getRecords($adminVO->organizationId, $openingId);
    
                                        foreach ($rows as $row) {
    
                                            $html = com\mik3\html\template\Application::getOrganizationSummary($row);
                                            echo $html;
                                        }
                                ?>
                            </div>
                            
                        </div> <!-- content -->
                      
                    </div>
                    
                    <div class="yui3-u-1-3">
                        <?php include($_SERVER['APP_WEB_DIR'] . '/inc/sidebar.inc'); ?>
                    </div>
                    
                </div> <!-- grid -->


            </div> <!-- bd -->

        </div> <!-- body wrapper -->
        
        <div id="ft">
            <?php include($_SERVER['APP_WEB_DIR'] . '/inc/site-footer.inc'); ?>
        </div>
            

    </body>
</html>




