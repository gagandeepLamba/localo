<?php
    include 'job-app.inc';
    include($_SERVER['APP_WEB_DIR'] . '/inc/header.inc');
    //check if user has customer admin role or not
    include($_SERVER['APP_WEB_DIR'] . '/inc/admin/role.inc');

    use com\indigloo\auth\FormAuthentication;
    use com\mik3\html\Link;
    use com\indigloo\Url;
    use com\mik3\html\UIData ;


    //This method will throw an error
    $adminVO = FormAuthentication::getLoggedInAdmin();
    $organizationId = $adminVO->organizationId;

    
    $gstatus = $gWeb->getRequestParam('g_status');
    if (empty($gstatus)) 
        $gstatus = 'A';
        
    $uifilters = UIData::getOpeningFilters();
	$filterName = $uifilters[$gstatus];
	
    //input sanity check
    if (!in_array($gstatus, array_keys($uifilters))) {
        trigger_error('Unknown status filter on UI', E_USER_ERROR);
    }


   
	$previousUrl = $gWeb->getPreviousUrl();
    $gWeb->addCurrentUrlToStack();

?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>

    <head><title> <?php echo $adminVO->organizationName; ?> Job Openings</title>


        <meta http-equiv="content-type" content="text/html;" />

        <link rel="stylesheet" type="text/css" href="/css/grids-min.css">
        <link rel="stylesheet" type="text/css" href="/css/style.css">

        <script type="text/javascript" src="/js/jquery-1.6.2.min.js"></script>
        <script type="text/javascript" src="/js/main.js"></script>

        <script type="text/javascript">

            
            $(document).ready(function(){
                openingObject.attachEvents();
				openingObject.debug = true ;
				
                //show all shy containers on document load!
                $(".hide-me").hide();
			
				$('.fb_top .afilter').click(function(){
					$(this).next().toggle();
					return false;
				});


            });


        </script>

    </head>


    <body>
    <?php include($_SERVER['APP_WEB_DIR'] . '/inc/toolbar.inc'); ?>

        <div id="body-wrapper">

            <div id="hd">
				<!-- no banner -->
            </div>
            <div id="bd">
                
                <div class="yui3-g">
                   

                    <div class="yui3-u-2-3">
                        <div id="content">
                            
							<div class="fb_top">
								<div class="fb_name navy floatl">
									Openings
									&nbsp;|&nbsp;
									
								</div>
								<div class="fb_filter floatl">
									Filter&nbsp; <a href="#" class="afilter navy"><?php echo $filterName; ?></a>
									
									<div class="fb_selector">
										
										<?php
											$template = '<a href="{href}" class="{class}"> {name} </a>' ;
											foreach ($uifilters as $code => $name) {
												$href = Url::addQueryParameters($_SERVER['REQUEST_URI'], array('g_status' => $code));
												$class = ($gstatus == $code) ? 'current' : 'normal' ;
												$link = str_replace(array( "{href}", "{class}", "{name}"),
																	array( 0 => $href, 1=> $class, 2 => $name),
																	$template);
												echo $link ;
											}

										
										?>
										
										
									</div>
								</div>
								<div class="clear"></div>
							</div> <!-- fb_top -->
                                
						
							 <!-- include opening list -->
							 <div class="opening">
								 <?php
									 $openingDao = new com\mik3\dao\Opening();
									 $rows = $openingDao->getRecordsOnOrgId($organizationId, array("status" => $gstatus));
									 foreach ($rows as $row) {
										 $html = com\mik3\html\template\Opening::getOrganizationSummary($row);
										 echo $html;
									 }
								 ?>
							 </div>

						</div> <!-- content -->
					</div>
					
					 <div class="yui3-u-1-3">
						<?php include($_SERVER['APP_WEB_DIR'] . '/inc/sidebar.inc'); ?>

                    </div> 

                </div> <!-- grid -->


            </div> <!-- bd -->
			
			
			<div id="js-debug"> </div>
				
        </div> <!-- body wrapper -->
	
		<div id="ft">
			<?php include($_SERVER['APP_WEB_DIR'] . '/inc/site-footer.inc'); ?>
		</div>
		

    </body>
</html>




