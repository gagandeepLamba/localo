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

    $previousUrl = $gWeb->getPreviousUrl();
    $gWeb->addCurrentUrlToStack();


?>



<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>

    <head><title> Applications sent by <?php echo $userVO->email ; ?> </title>
        

        <meta http-equiv="content-type" content="text/html; charset=ISO-8859-1" />

        <link rel="stylesheet" type="text/css" href="/css/grids-min.css">
        <link rel="stylesheet" type="text/css" href="/css/style.css">
            
        <script type="text/javascript" src="/js/jquery-1.6.2.min.js"></script>
        <script type="text/javascript" src="/js/main.js"></script>

        <script type="text/javascript">

            $(document).ready(function(){

            });

                //show on demand


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
                                        <div class="fb_name navy floatl">My Applications </div>
                                    
                                        <div class="clear"></div>
                                    </div> <!-- fb_top -->
                                    
                                        
                                    <div class="opening">
                                        <?php
                                        //applications
                                        $applicationDao = new webgloo\job\dao\Application();
                                        $rows = $applicationDao->getRecordsOnUserId($userVO->uuid);
                                        
                                        foreach ($rows as $row) {
                                            $html = webgloo\job\html\template\Application::getUserSummary($row, array("itemCss" => "mt20 bbd5"));
                                            echo $html;
                                            
                                        }
                                    ?>
                                    </div>
                                    

                            </div>

                        </div>
                    </div> <!-- GRID -->

                </div> <!-- bd -->



            </div> <!-- body wrapper -->
            
            <?php include($_SERVER['APP_WEB_DIR'] . '/inc/site-footer.inc'); ?>
            
            
    </body>
</html>




