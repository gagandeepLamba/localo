<?php
    //find post on seo title
    $postDao = new \com\indigloo\news\dao\Post();
    $postDBRow = $postDao->getRecordOnShortId($shortId);
    $postId = $postDBRow['id'];
    
    $mediaDBRows = $postDao->getMediaOnId($postId);
    $description = empty($postDBRow['description']) ? $postDBRow['summary'] : $postDBRow['description'] ;
    
	$metaDescription = strip_tags($postDBRow['summary']);
	$metaDescription = \com\indigloo\Util::abbreviate($metaDescription,180);

?>



<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>

    <head><title> <?php echo $postDBRow['title']; ?> </title>

        <meta http-equiv="content-type" content="text/html; charset="utf-8" />
        <meta name="keywords" content="27main, pictures,india news, entertainment, indian politics, headline news, offbeat, created by users, bookmarking site">
        <meta name="description" content="<?php echo $metaDescription;  ?>">
        
        <link rel="stylesheet" type="text/css" href="/lib/yui3/grids-min.css">
        <link rel="stylesheet" type="text/css" href="/css/style.css">
            
        <script type="text/javascript" src="/lib/jquery/jquery-1.6.4.min.js"></script>
        <script type="text/javascript" src="/lib/jquery/jquery.tinycarousel.min.js"></script>
        
        <script type="text/javascript">			
            $(document).ready(function(){				
                        
                $('#slider-code').tinycarousel({ pager: true });
                
            });
        </script>
        
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
                            <div class="mt20">
                                <h1> <?php echo $postDBRow['title'] ; ?> </h1>
                            </div>
                            
                            <?php if(sizeof($mediaDBRows) > 0 ) { include('inc/slider.inc') ; } ?>
                            
                          
                            <div class="widget">
                                <div class="regular bbd5">
                                    <?php echo $description ; ?>
                                </div>
                            </div>
                            
                            
                        </div> <!-- content -->

                    </div>
                    
                    <div class="yui3-u-1-3">
                        <?php include($_SERVER['APP_WEB_DIR'] . '/inc/sidebar.inc'); ?>
                        <div class="p20">
                        <hr>
                        short url for mobiles &raquo;<b> 27ma.in/<?php echo $shortId; ?> </b>
                        </div>
                        
                    </div>
                    
                    
                </div>


            </div> <!-- bd -->



        </div> <!-- body wrapper -->

        <div id="ft">
            <?php include($_SERVER['APP_WEB_DIR'] . '/inc/site-footer.inc'); ?>
        </div>

    </body>
</html>
