<?php
    //find post on seo title
    $postDao = new \com\indigloo\news\dao\Post();
    $postDBRow = $postDao->getRecordOnShortId($shortId);
    $postId = $postDBRow['id'];
    
  
    $description = empty($postDBRow['description']) ? $postDBRow['summary'] : $postDBRow['description'] ;
    
	$metaDescription = strip_tags($postDBRow['summary']);
	$metaDescription = trim($metaDescription);
	$metaDescription = \com\indigloo\Util::abbreviate($metaDescription,180);

    $postedOn = \com\indigloo\Util::formatDBTime($postDBRow['created_on']);
    
    $strImagesJson = empty($postDBRow['images_json']) ? '[]' : $postDBRow['images_json'] ;
    $strLinksJson = empty($postDBRow['links_json']) ? '[]' : $postDBRow['links_json'] ;
    $images = json_decode($strImagesJson);
    $links = json_decode($strLinksJson);
    
?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>

    <head><title> <?php echo $postDBRow['title']; ?> </title>

        <meta http-equiv="content-type" content="text/html; charset="utf-8" />
        <meta name="keywords" content="27main, pictures,india news, entertainment, indian politics, headline news, offbeat, created by users, bookmarking site">
        <meta name="description" content="<?php echo $metaDescription;  ?>">
        
        <link rel="stylesheet" type="text/css" href="/3p/yui3/grids-min.css">
        <link rel="stylesheet" type="text/css" href="/css/news.css">
            
        <script type="text/javascript" src="/3p/jquery/jquery-1.6.4.min.js"></script>
        <script type="text/javascript" src="/3p/jquery/jquery.tinycarousel.min.js"></script>
        
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

                        <div id="content">
                            <div class="mt20">
                                <h1> <?php echo $postDBRow['title'] ; ?> </h1>
                                 <div class="details">
                                    <span class="b"> <?php echo $postDBRow['user_name'] ; ?> </span>
                                    <span> posted on <?php echo $postedOn; ?> </span>
                                </div>
                            </div>
                            
                            <?php if(sizeof($images) > 0 ) { include('inc/slider.inc') ; } ?>
                            
                          
                            <div class="widget">
                                <div class="article-body">
                                    <?php echo $description ; ?>
                                    <br/>
                                    
                                    <div class="mt20">
                                        <h3> Story Link </h3>
                                        <?php
                                            $strLink = '<a href="{link}" target="_blank"> {link} </a> <br/>' ;
                                            
                                            foreach($links as $link) {
                                                $linkHtml = str_replace("{link}",$link,$strLink);
                                                echo $linkHtml;
                                                
                                            }
                                        
                                        ?>
                                    </div>
                                    
                                </div>
                            </div>
                            
                            <?php
                                    
                                if(\com\indigloo\auth\User::isAdmin()) {
                                    echo \com\indigloo\news\html\Post::getEditPostButton($postDBRow) ;
                                }
                            ?>
                           
                            
                        </div> <!-- content -->

                    </div>
                    
                    <div class="yui3-u-1-3">
                        <?php include($_SERVER['APP_WEB_DIR'] . '/inc/sidebar/default.inc'); ?>
                    </div>
                    
                    
                </div>


            </div> <!-- bd -->



        </div> <!-- body wrapper -->

        <div id="ft">
            <?php include($_SERVER['APP_WEB_DIR'] . '/inc/site-footer.inc'); ?>
        </div>

    </body>
</html>
