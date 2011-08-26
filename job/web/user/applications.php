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

    <head><title> Applications sent by <?php echo $userVO->email ; ?> </title>
        

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
                                
                                <span class="header"> My Applications (<?php echo $userVO->email; ?>) </span>
                                
                                        <?php
                                        //applications
                                        $applicationDao = new webgloo\job\dao\Application();
                                        $rows = $applicationDao->getRecordsOnUserId($userVO->uuid);
                                        
                                        foreach ($rows as $row) {
                                            $html = webgloo\job\html\template\Application::getUserSummary($row, array("user" => $userVO->email));
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




