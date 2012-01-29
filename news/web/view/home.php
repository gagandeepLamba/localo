<?php

    use \com\indigloo\ui\Pagination as Pagination;
    use \com\indigloo\Url as Url;
    
    $postDao = new \com\indigloo\news\dao\Post();
    $postDBRows = $postDao->getLatestPostWithMedia();
    //find total number of pages
    $totalPages = $postDao->getTotalPages();
    $paginator = new Pagination($pageNo,$totalPages);
    
    $pageURI = 'http://www.27main.com' ;

?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>

    <head><title> 27main - source of news and content from India - created by you</title>

        <meta http-equiv="content-type" content="text/html; charset="utf-8" />
        <meta name="keywords" content="27main, pictures,india news, entertainment, indian politics, headline news, offbeat, created by users, bookmarking site">
        <meta name="description" content="27 main is a source of news and content from India - All created by its users">
                                    
        <link rel="stylesheet" type="text/css" href="/3p/yui3/grids-min.css">
        <link rel="stylesheet" type="text/css" href="/css/news.css">
        
        
    </head>


    <body>
        <?php include($_SERVER['APP_WEB_DIR'] . '/inc/fb-sdk.inc'); ?>
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
        <div id="feedback" class="vertical">
            S e n d
            <br />
            <br />
            F e e d b a c k
        </div>
        
        <div id="ft">
            <?php include($_SERVER['APP_WEB_DIR'] . '/inc/site-footer.inc'); ?>
        </div>

    </body>
</html>
