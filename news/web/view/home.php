

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>

    <head><title> News site</title>

        <meta http-equiv="content-type" content="text/html; charset=ISO-8859-1" />

        <link rel="stylesheet" type="text/css" href="/lib/yui3/grids-min.css">
        <link rel="stylesheet" type="text/css" href="/css/style.css">
        
        
    </head>


    <body>

        <?php include($_SERVER['APP_WEB_DIR'] . '/inc/toolbar.inc'); ?>

        <div id="body-wrapper">

            <div id="hd">
                <?php include($_SERVER['APP_WEB_DIR'] . '/inc/banner.inc'); ?>
            </div>
            <div id="bd">

                <div class="yui3-g">
                   
                    <div class="yui3-u-2-3">

                        <div id="main-panel">
                            <?php
                            
                                $start = NULL ;
                                $end = NULL ;
                                
                                if(sizeof($postDBRows) > 0 ) { 
                                    $start = $postDBRows[0]['id'] ;
                                    $end =   $postDBRows[sizeof($postDBRows)-1]['id'] ;
                                }
                                
                                foreach($postDBRows as $postDBRow) {
                                    
                                    $html = \com\indigloo\news\html\Post::getMainPageSummary($postDBRow);
                                    echo $html ;
                                }
                                
                            ?>
                            
                            <?php
                                $paginator->render('/index2.php',$start,$end);
                            ?>
                            
                        </div> <!-- content -->
                
                    </div>
                    
                    <div class="yui3-u-1-3">
                        <?php include($_SERVER['APP_WEB_DIR'] . '/inc/sidebar.inc'); ?>
                    </div>
                    
                    
                </div>


            </div> <!-- bd -->



        </div> <!-- body wrapper -->

        <div id="ft">
            <?php include($_SERVER['APP_WEB_DIR'] . '/inc/site-footer.inc'); ?>
        </div>

    </body>
</html>
