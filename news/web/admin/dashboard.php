<?php
    //admin/dashboard.php
    include ('news-app.inc');
    include($_SERVER['APP_WEB_DIR'] . '/inc/header.inc');
    include($_SERVER['APP_WEB_DIR'] . '/inc/role/admin.inc');
	
	
	use \com\indigloo\auth\User as User ;
    
    
    $startId = NULL;
    $endId = NULL ;
    $linkDBRows = NULL ;
    
    $postDao = new \com\indigloo\news\dao\Post();
    
    if(array_key_exists('after',$_GET)) {
        $index = base_convert($_GET['after'],36,10);
        $linkDBRows = $postDao->getLinks($index,'after');
	} elseif (array_key_exists('before',$_GET)) {
        $index = base_convert($_GET['before'],36,10);
		$linkDBRows = $postDao->getLinks($index,'before');
	} else {
        $linkDBRows = $postDao->getLatestLinks();
    }
    
    
    if(sizeof($linkDBRows) > 0 ) {
        $startId = $linkDBRows[0]['id'] ;
        $endId =   $linkDBRows[sizeof($linkDBRows)-1]['id'] ;
    }
    
    $pageNo = array_key_exists('pageNo',$_GET) ? $_GET['pageNo'] : 1 ;
    
    $totalLinks = $postDao->getTotalLinks();
    $paginator = new \com\indigloo\ui\Pagination($pageNo,$totalLinks);
            
                                    
	
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
        
        <script type="text/javascript" src="/js/news.js"></script>
        
        <script type="text/javascript">
            
            $(document).ready(function(){
                webgloo.news.admin.init();
                webgloo.news.admin.attachEvents();
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
                                $json = array();
                                foreach($linkDBRows as $linkDBRow) {
                                    echo \com\indigloo\news\html\Link::getSummary($linkDBRow,$count) ;
                                    $count++ ;
                                    $json[$linkDBRow['id']] = $linkDBRow['state'];
                                }
                                $json = json_encode($json);
                            
                            ?>
                            
							<div id="form-wrapper">
                                <form id="web-form1" class="web-form" name="web-form1" action="/admin/form/dashboard.php" enctype="multipart/form-data"  method="POST">
                                    <input id="states_json" name="states_json" type="hidden" value ='<?php echo $json; ?>' />
                                    <div id="link-container">
                                        <button class="submit" type="submit" name="save" value="Save" onclick="this.setAttribute('value','Save');" ><span>Click to Save the changes!</span></button>    
                                    </div>
                                    
                                </form>
                             </div>
                             
                            <?php $paginator->render('/admin/dashboard.php',$startId,$endId);  ?>
                           
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
