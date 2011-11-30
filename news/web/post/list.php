<?php
    //post/list.php
    include ('news-app.inc');
    include($_SERVER['APP_WEB_DIR'] . '/inc/header.inc');
    
	$postDao = new \com\indigloo\news\dao\Post();
    $postDBRows = $postDao->getRecords();

?>



<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>

    <head><title> All Posts</title>

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

                        <div id="content">
							<div class="fb_top">
								<div class="fb_name navy floatl">
									All posts
									
								</div>
								
							</div> <!-- fb_top -->
							<div>
								<table class="doc-table pt10">
									<?php
										$strRowItem = '<tr class="item"> <td> {count}. </td> <td> {title}</td> ' ;
										$strRowItem .= '<td><a href="/post/edit.php?g_post_id={postId}"> Edit</a>  </td>';
										$strRowItem .= '<td><a href="#"> Delete</a>  </td> </tr>';
										
										$count = 1;
										foreach($postDBRows as $postDBRow) {
											$rowItem = str_replace(array( 0 => "{count}", 1=> "{title}", 2=>"{postId}"),
																   array(0 => $count, 1 => $postDBRow['title'], 2=> $postDBRow['id']),
																   $strRowItem);
											
											echo $rowItem;	
											$count++ ;
											
										}
									
									
									?>
									
									
                                </table>
								
							</div>
							
                        </div> <!-- content -->

                    </div>
                    
                    <div class="yui3-u-1-3">
                        <?php include($_SERVER['APP_WEB_DIR'] . '/inc/sidebar.inc'); ?>
                    </div>
                    
                    
                </div> <!-- GRID -->


            </div> <!-- bd -->



        </div> <!-- body wrapper -->

        <div id="ft">
            <?php include($_SERVER['APP_WEB_DIR'] . '/inc/site-footer.inc'); ?>
        </div>

    </body>
</html>
