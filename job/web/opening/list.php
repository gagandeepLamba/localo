<?php
    include 'job-app.inc';
    include($_SERVER['APP_WEB_DIR'] . '/inc/header.inc');
    //check if user has customer admin role or not
    include($_SERVER['APP_WEB_DIR'] . '/inc/admin/role.inc');

    use webgloo\auth\FormAuthentication;
    use webgloo\job\html\Link;
    use webgloo\common\Url;
    use webgloo\job\html\UIData ;


    //This method will throw an error
    $adminVO = FormAuthentication::getLoggedInAdmin();
    $organizationId = $adminVO->organizationId;

    
    $gstatus = $gWeb->getRequestParam('g_status');
    if (empty($gstatus)) 
        $gstatus = 'A';
        
    $uifilters = UIData::getOpeningFilters();

    //input sanity check
    if (!in_array($gstatus, array_keys($uifilters))) {
        trigger_error('Unknown status filter on UI', E_USER_ERROR);
    }


    $flinks = array();
    foreach ($uifilters as $code => $name) {
        $link = Url::addQueryParameters($_SERVER['REQUEST_URI'], array('g_status' => $code));
        $flinks[$code] = $link;
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

        <!-- include any javascript here -->
        <script type="text/javascript">

            var openingObject = {
                debug :  false ,
                actions : function(status){
                    var data = new Array();
                    switch (status){
                        case 'A' :
                            data["C"] = "close";
                            data["S"] = "suspend" ;
                            data["EX2W"] = "extend for 2 weeks" ;
                            data["EX4W"] = "extend for 4 weeks" ;
                            
                            break ;
                        case 'C' :
                            data["A"] = "make active";
                            break ;
                        case 'E' :
                            data["A"] = "make active";
                            break ;
                        default :
                            break ;
                    }

                    return data ;
                }
                

            };

            openingObject.closeToolbar = function(toolbarId) {
                if(openingObject.debug){
                    alert("removing toolbar div :: " + toolbarId);
                }
                $("div#"+toolbarId).remove();
            } ;

            openingObject.addEditLinks = function(openingId,status) {
                if(openingObject.debug){
                    alert("add edit links for opening " + openingId + " and status " + status);
                }
                
                //get associative array of status code and display names
                var actions = openingObject.actions(status);
                var toolbarId = "opening-toolbar-" + openingId ;
                openingObject.closeToolbar(toolbarId);
                
                //iterate thorugh array and print it
                var template = '<a href="/opening/post/quick-action.php?g_opening_id={gOpeningId}&action={gCode}&g_status={gstatus}">{name} </a> &nbsp;&nbsp;';
                var buffer = '' ;
                for (var key in actions) {
                    var params = {gOpeningId: openingId ,gCode: key, name:actions[key], gstatus :status};
                    if(openingObject.debug){
                        alert("Adding actions link :: code " + key + " name :: " + actions[key]);
                    }
                    
                    buffer = buffer + template.supplant(params);
                    
                }

                //add close toolbar link
                buffer = buffer + '<a href="#" id="' +toolbarId + '" class="opening-toolbar-close"> <img src="/css/images/cross.png" alt="x"> </a>&nbsp;' ;
                //wrap links in toolbar DIV
                buffer = '<div class="ajax-toolbar" id="' + toolbarId + '">' + buffer + '</div>';
                $("div#opening-"+openingId).append(buffer);
                
            };


            $(document).ready(function(){

                //Attach a live event to removeLink
                // live event is required to attach event to future DOM elements
                $("a.more-link").live("click", function(event){
                    event.preventDefault();
                    var paragraphId = $(this).attr("id");
                    //hide summary
                    $("#summary-"+paragraphId).hide();
                    //show description
                    $("#description-"+paragraphId).slideDown("slow");
                    

                }) ;

                $("a.less-link").live("click", function(event){
                    event.preventDefault();
                    var paragraphId = $(this).attr("id");
                    //hide description
                    $("#description-"+paragraphId).slideUp("slow");
                    //show summary
                    $("#summary-"+paragraphId).show();
                }) ;

                $("a.opening-action-link").live("click", function(event){
                    event.preventDefault();
                    var openingId = $(this).attr("id");
                    openingObject.addEditLinks(openingId,"<?php echo $gstatus; ?>");
					
                    
                }) ;

                $("a.opening-toolbar-close").live("click", function(event){
                    event.preventDefault();
                    var toolbarId = $(this).attr("id");
                    openingObject.closeToolbar(toolbarId);

                }) ;

                //show all shy hide-me containers on document load!
                $(".hide-me").hide();
			

	
				$('.fb_top .afilter').click(function(){
					$(this).next().toggle();
					return false;
				});


            });

            openingObject.debug = false ;


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
                    <div class="yui3-u-1-3">
						<?php include($_SERVER['APP_WEB_DIR'] . '/inc/left-panel.inc'); ?>

                    </div> <!-- left unit -->


                    <div class="yui3-u-2-3">
                        <div id="content">
                            
							<div class="fb_top">
								<div class="fb_name navy floatl">
									Openings
									&nbsp;|&nbsp;
									<a href="/opening/create.php">Create </a>
								</div>
								<div class="fb_filter floatl">
									Filter: <a href="#" class="afilter navy">Active</a>
									<div class="fb_selector">
										<a href="/opening/list.php?g_status=*">All</a>
										<a class="current" href="/opening/list.php?g_status=A">Active</a>
										<a href="/opening/list.php?g_status=E">Expired</a>
										<a href="/opening/list.php?g_status=S">Suspended</a>
										<a href="/opening/list.php?g_status=C">Closed</a>
									</div>
								</div>
								<div class="clear"></div>
							</div> <!-- fb_top -->
                                
						
							 <!-- include opening list -->
							 <div class="opening">
								 <?php
									 $openingDao = new webgloo\job\dao\Opening();
									 $rows = $openingDao->getRecordsOnOrgId($organizationId, array("status" => $gstatus));
									 foreach ($rows as $row) {
										 $html = webgloo\job\html\template\Opening::getOrganizationSummary($row);
										 echo $html;
									 }
								 ?>
							 </div>

						</div> <!-- content -->
					</div>
					
                </div> <!-- GRID -->


            </div> <!-- bd -->

        </div> <!-- body wrapper -->
	
		<div id="ft">
			<?php include($_SERVER['APP_WEB_DIR'] . '/inc/site-footer.inc'); ?>
		</div>
		

    </body>
</html>




