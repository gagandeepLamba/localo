<?php

    //sc/index
    include ('sc-app.inc');
    include($_SERVER['APP_WEB_DIR'] . '/inc/header.inc');
    
    use com\indigloo\Util;
    use com\indigloo\ui\form\Sticky;
    use com\indigloo\Constants as Constants;
    use com\indigloo\ui\form\Message as FormMessage;
     
    $sticky = new Sticky($gWeb->find(Constants::STICKY_MAP,true));
    
	$questionDao = new \com\indigloo\sc\dao\Note();
    $questionDBRows = $questionDao->getAll($_GET['stoken'], $_GET['ft']);
	$index = 0 ;
    
?>  

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>

       <head><title> 3mik.com - Home page  </title>
         

        <meta http-equiv="content-type" content="text/html; charset=ISO-8859-1" />

        <link rel="stylesheet" type="text/css" href="/3p/yui3/grids-min.css">
        <link rel="stylesheet" type="text/css" href="/css/sc.css">
        
  
       
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
								<div class="yui3-g">
									<div class="yui3-u navbox">
										<a href="/qa/ask.php"> Ask &raquo; </a>
									</div>
									<div class="yui3-u navbox">
										<a href="/qa/wish.php"> Wish &raquo;</a>
									</div>
									<div class="yui3-u navbox">
										<a href="/qa/share.php">Share &raquo;</a>
									</div>
									
								</div> <!-- top grid -->
								
								<div class="yui3-g">
									<div class="yui3-u-1-2">
										<?php
											for($index = 0 ; ($index < sizeof($questionDBRows)) && ($index < 3); $index++) {
												$questionDBRow = $questionDBRows[$index];
												$html = \com\indigloo\sc\html\Note::getSummary($questionDBRow,1);
												echo $html ;
										
											}
										?>
									</div>
									<div class="yui3-u-1-2">
										<?php
											for($index = 3 ; ($index < sizeof($questionDBRows)) && ($index < 6); $index++) {
												$questionDBRow = $questionDBRows[$index];
												$html = \com\indigloo\sc\html\Note::getSummary($questionDBRow,1);
												echo $html ;
											}
										?>
									</div>
									
									
								</div> <!-- 2 col grid -->
								
								
								
								
								<?php
									for($index = 6; $index < sizeof($questionDBRows) ; $index++) {
										$questionDBRow = $questionDBRows[$index];
										$html = \com\indigloo\sc\html\Note::getSummary($questionDBRow,2);
										echo $html ;
								
									}
								?>
                                   
                            </div> <!-- content -->


                        </div> <!-- u-2-3 -->
                        
                         <div class="yui3-u-1-3">
                            <!-- sidebar -->
							<?php include($_SERVER['APP_WEB_DIR'] . '/inc/sidebar.inc'); ?>
                        </div> <!-- u-1-3 -->
                        
                    </div> <!-- GRID -->


                </div> <!-- bd -->


              <div id="js-debug"> </div>
              
              
        </div> <!-- body wrapper -->
        <div id="ft">
            <?php include($_SERVER['APP_WEB_DIR'] . '/inc/site-footer.inc'); ?>
        </div>

    </body>
</html>
