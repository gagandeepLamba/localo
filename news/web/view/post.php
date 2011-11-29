<?php
    //find post on seo title
    $postDao = new \com\indigloo\news\dao\Post();
    $postDBRow = $postDao->getRecordOnSeoTitle($seoTitle);
    $postId = $postDBRow['id'];
    
    $jwRotatorSwfURI = \com\indigloo\news\Url::getJWRotatorSwfURI();
    $jwRotatorTrackURI = \com\indigloo\news\Url::getJWRotatorTrackURI($postId);
    
    $mediaDBRows = $postDao->getMediaOnId($postId);
    

?>



<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>

    <head><title> News site</title>

        <meta http-equiv="content-type" content="text/html; charset=ISO-8859-1" />

        <link rel="stylesheet" type="text/css" href="/lib/css/yui3/grids-min.css">
        <link rel="stylesheet" type="text/css" href="/css/style.css">
            
        <script type="text/javascript" src="/lib/js/jquery/jquery-1.6.4.min.js"></script>
        <script type="text/javascript" src="/js/jquery.tinycarousel.js"></script>
          
        <style type="text/css">
            
            #slider-code { height:345px; overflow:hidden; }
            #slider-code .viewport { float: left; width: 400px; height: 300px; overflow: hidden; position: relative;padding:10px; }
            #slider-code .buttons {display: block; margin: 120px 10px 0 0; float: left; }
            #slider-code .next { margin: 120px 10px 0 10px;  }
            #slider-code .disable { visibility: hidden; }
            #slider-code .overview { list-style: none; padding: 0; margin: 0;  position: absolute; left: 0; top: 0; }
            #slider-code .overview li{ float: left; margin: 0 20px 0 0; padding: 1px; height: 300px; border: 1px solid #dcdcdc; width: 400px;}
            
            #slider-code .pager { overflow:hidden; list-style: none; clear: both; margin: 0 0 0 45px; }
            #slider-code .pager li { float: left; }
            #slider-code .pagenum { background-color: #fff; text-decoration: none; text-align: center; padding: 5px; color: #555555; font-size: 14px; font-weight: bold; display: block; }
            #slider-code .active { color: #fff; background-color:  #555555; }
            #slider-code a { font-size:14px; font-weight:bold;}

        </style>
        
        <script type="text/javascript">			
            $(document).ready(function(){				
                        
                $('#slider-code').tinycarousel({ pager: true });
                
            });
        </script>
        
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
                            
                            <h1> <?php echo $postDBRow['title'] ; ?> </h1>
                            
                             <div id="slider-code">
                                <a href="#" class="buttons prev">&laquo;&nbsp;Previous</a>
                                <div class="viewport">
                                    <ul class="overview">
                                        <?php
                                            $strItem = ' <li><img src="/{bucket}/{storedName}" class="resize"></li> ';
                                            
                                            foreach($mediaDBRows as $mediaDBRow) {
                                                $item = str_replace(array(0 => "{bucket}", 1 => "{storedName}"),
                                                                    array(0 => $mediaDBRow['bucket'], 1 => $mediaDBRow['stored_name']),
                                                                    $strItem);
                                                echo $item;
                                                
                                            }
                                        
                                        ?>
                                        
                                    </ul>
                                </div>
                                <a href="#" class="buttons next">Next&nbsp;&raquo;</a>
                                <ul class="pager">
                                    <?php
                                        for($i = 0 ; $i < sizeof($mediaDBRows) ; $i++) {
                                            echo '<li><a rel="'.$i.'" class="pagenum" href="#">'.($i+1).'</a></li>' ;
                                        }
                                    
                                    ?>
                                    
                                </ul>
                            </div>
                             
                             
                             
                             <div class="widget rotator">
     
                                <!--
                                <embed src="<?php echo $jwRotatorSwfURI; ?>"
                                    wmode=opaque
                                    allowscriptaccess="always"
                                    allowfullscreen="true"
                                    allowresize="true"
                                    width="600" height="400"
                                    flashvars="file=<?php echo $jwRotatorTrackURI; ?>" />
                                 -->
                                 
                            </div>
                            
                            <div class="widget">
                                <div class="regular">
                                    <p>
                                    <?php echo $postDBRow['description'] ; ?>
                                    </p>
                                    
                                </div>
                            </div>
                            
                            
                            
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
