<?php

    //sc/user/data/question.php
    include ('sc-app.inc');
    include($_SERVER['APP_WEB_DIR'] . '/inc/header.inc');
	include($_SERVER['APP_WEB_DIR'] . '/inc/role/user.inc');
    
    use com\indigloo\Util;
	 
	if(is_null($gSessionUser)) {
		$gSessionUser = \com\indigloo\auth\User::getUserInSession();
	}
	
	$questionDao = new \com\indigloo\sc\dao\Question();
    $questionDBRows = $questionDao->getAllOnUserEmail($gSessionUser->email);
	
?>  

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>

       <head><title> Questions asked by <?php echo $gSessionUser->firstName; ?>  </title>
         

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
								<h1> Questions asked by <?php echo $gSessionUser->firstName; ?> </h1>
								<hr>
									
								<?php
									foreach($questionDBRows as $questionDBRow) {
										$html = \com\indigloo\sc\html\Question::getLinkView($questionDBRow);
										echo $html ;
								
									}
								?>
                                   
                            </div> <!-- content -->


                        </div> 
                        
                         <div class="yui3-u-1-3">
                            <!-- sidebar -->
							
                        </div>
                        
                    </div>

                </div> <!-- bd -->


              <div id="js-debug"> </div>
              
              
        </div> <!-- body wrapper -->
        <div id="ft">
            <?php include($_SERVER['APP_WEB_DIR'] . '/inc/site-footer.inc'); ?>
        </div>

    </body>
</html>
