<?php
   
    //view/home.php
    
    use \com\indigloo\ui\Pagination as Pagination;
    use \com\indigloo\Url as Url;
    
    $postDao = new \com\indigloo\news\dao\Post();
    $pageSize = 10 ;
    $postDBRows = $postDao->getRecordsWithMedia($pageNo,$pageSize);
    $postDBRowsCount = $postDao->getRecordsWithMediaCount();
    $paginator = new Pagination($pageNo,$postDBRowsCount,$pageSize);
    
    
?>



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
                            
                                foreach($postDBRows as $postDBRow) {
                                    /* $postVO = \com\indigloo\news\view\Post::create($postDBRow);*/
                                    $html = \com\indigloo\news\html\Post::getMainPageSummary($postDBRow);
                                    echo $html ;
                                }
                            ?>
                            
                            <?php $paginator->renderSeo(Url::base()); ?>
                            
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
