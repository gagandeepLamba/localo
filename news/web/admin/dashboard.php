<?php
    //admin/dashboard.php
    include ('news-app.inc');
    include($_SERVER['APP_WEB_DIR'] . '/inc/header.inc');
    include($_SERVER['APP_WEB_DIR'] . '/inc/role/admin.inc');
	
	$postDao = new \com\indigloo\news\dao\Post();
    $linkDBRows = $postDao->getLatestLinks();

	use \com\indigloo\auth\User as User ;
    
	
?>



<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>

    <head><title> Admin Dashboard</title>

        <meta http-equiv="content-type" content="text/html; charset=ISO-8859-1" />

        <link rel="stylesheet" type="text/css" href="/3p/yui3/grids-min.css">
        <link rel="stylesheet" type="text/css" href="/css/news.css">
        
        <script type="text/javascript" src="/3p/jquery/jquery-1.6.4.min.js"></script>
         <!-- fancybox -->
        <script type="text/javascript" src="/3p/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
        <link rel="stylesheet" href="/3p/fancybox/jquery.fancybox-1.3.4.css" type="text/css" media="screen" />
        
        <script type="text/javascript">
            
            $(document).ready(function(){
                
               $(".fbox").fancybox({
                    'title'             : 'press esc to close',
                    'width'				: '75%',
                    'height'			: '75%',
                    'autoScale'     	: false,
                    'transitionIn'		: 'none',
                    'transitionOut'		: 'none',
                    'type'				: 'iframe'
                });
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

                        <div id="content">
							<h2> Admin Dashboard </h2>
							<?php
                            $count = 1;
                            foreach($linkDBRows as $linkDBRow) {
                                echo \com\indigloo\news\html\Link::getSummary($linkDBRow,$count) ;
                                $count++ ;
                            }
                            
                            ?>
							
                        </div> <!-- content -->

                    </div>
                    
                    <div class="yui3-u-1-3">
                        <?php include($_SERVER['APP_WEB_DIR'] . '/inc/sidebar/default.inc'); ?>
                    </div>
                    
                    
                </div> <!-- GRID -->


            </div> <!-- bd -->



        </div> <!-- body wrapper -->

        <div id="ft">
            <?php include($_SERVER['APP_WEB_DIR'] . '/inc/site-footer.inc'); ?>
        </div>

    </body>
</html>
