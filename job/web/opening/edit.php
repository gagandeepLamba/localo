<?php
    include 'job-app.inc';
    include($_SERVER['APP_WEB_DIR'] . '/inc/header.inc');
    //check if user has customer admin role or not
    include($_SERVER['APP_WEB_DIR'] . '/inc/admin/role.inc');
    
    use com\indigloo\auth\FormAuthentication;
    use com\mik3\html\Link;
    use com\indigloo\Url;
    use com\indigloo\Util ;
    use com\indigloo\ui\form\Sticky ;
    use com\mik3\Constants ;
    use com\mik3\html\UIData ;

    //This method will throw an error
    $adminVO = FormAuthentication::getLoggedInAdmin();
    $organizationId = $adminVO->organizationId;
    
    //find and destroy sticky map
    $sticky = new Sticky($gWeb->find(Constants::STICKY_MAP,true));
    $openingId = $gWeb->getRequestParam('g_opening_id');
    Util::isEmpty('openingId',$openingId);

    //security - do not show opening_id not belonging to user organization
    $openingDao = new com\mik3\dao\Opening();
    $openingDBRow = $openingDao->getEditRecordOnId($adminVO->organizationId,$openingId);

    //sanity test - we should have a record to edit
    $openingDao->checkNull($openingDBRow);
    
    $uifilters = UIData::getOpeningFilters();
    // see if it expired?
    $seconds = Util::secondsInDBTimeFromNow($openingDBRow['expire_on']);
    
    if($seconds < 0 ) {
            //expired
            $openingDBRow['status'] = 'E';
            $displayStatus = 'Expired on '.Util::formatDBTime($openingDBRow['expire_on']);
    } else {
            $displayStatus = $uifilters[$openingDBRow['status']].' (Expiring on '.Util::formatDBTime($openingDBRow['expire_on']).')';
    }

    //get actions array of code vs display name for DB status
    $actions = UIData::getOpeningActions($openingDBRow['status']);
    $previousUrl = $gWeb->getPreviousUrl();
		
?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>

    <head><title> <?php echo $adminVO->organizationName; ?> Job Openings</title>


        <meta http-equiv="content-type" content="text/html;" />

        <link rel="stylesheet" type="text/css" href="/css/grids-min.css">
        <link rel="stylesheet" type="text/css" href="/css/style.css">
		<script type="text/javascript" src="/js/jquery-1.6.2.min.js"></script>
		

    </head>


    <body>
        <?php include($_SERVER['APP_WEB_DIR'] . '/inc/toolbar.inc'); ?>

        <div id="body-wrapper">

            <div id="hd">
                <?php include($_SERVER['APP_WEB_DIR'] . '/inc/banner.inc'); ?>
            </div>
            <div id="bd">
                <!-- grid DIV -->
                <div class="yui3-g">
                    

                    <div class="yui3-u-2-3">
                        <div id="content">
                            <h2> Edit &dash;&nbsp;<?php echo  $openingDBRow['title']; ?> </h2> 
                            <p> status &nbsp;&dash;&nbsp; <?php echo $displayStatus; ?> </p>
                            <?php include($_SERVER['APP_WEB_DIR'] . '/inc/form/message.inc'); ?>
                             
                            <div id="form-wrapper">
                                <form id="web-form1" class="web-form" name="web-form1" action="/opening/post/edit.php" enctype="multipart/form-data"  method="POST">

                                    <div class="error">    </div>

                                    <table class="form-table">

                                        <tr>
                                            <td class="field"> Bounty<span class="red-label">*</span></td>
                                            <td>
                                                <input type="text" name="bounty" maxlength="6" class="required w280" title="&gt;&nbsp;Bounty is a required field" value="<?php echo $sticky->get('bounty', $openingDBRow['bounty']); ?>"/>
                                            </td>
                                        </tr>

                                        <!-- location - fill in with default company location -->
                                        <tr>
                                            <td class="field"> Location<span class="red-label">*</span></td>
                                            <td>
                                                <input type="text" name="location" maxlength="32" class="required w280" title="&gt;&nbsp;Location is a required field" value="<?php echo $sticky->get('location', $openingDBRow['location']); ?>"/>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="field"> Title<span class="red-label">*</span></td>
                                            <td>
                                                <input type="text" name="title" maxlength="100" class="required" title="&gt;&nbsp;Title is a required field" value="<?php echo $sticky->get('title', $openingDBRow['title']); ?>"/>
                                            </td>
                                        </tr>

                                         <tr>
                                            <td class="field"> Experience</td>
                                            <td>
                                                <input type="text" name="min_experience" class="w80" maxlength="2" value="<?php echo $sticky->get('min_experience',$openingDBRow['min_experience']); ?>"/>
                                                &nbsp;to&nbsp;
                                                <input type="text" name="max_experience" class="w80" maxlength="2" value="<?php echo $sticky->get('max_experience',$openingDBRow['max_experience']); ?>"/>
                                                &nbsp;years&nbsp;

                                            </td>

                                        </tr>

                                        <tr>
                                            <td colspan="2">
												<span> Desired skills </span>
												<br>
												<textarea  name="skill" class="h130 w580" cols="50" rows="4" ><?php echo $sticky->get('skill', $openingDBRow['skill']); ?></textarea>
											</td>
                                        </tr>

                                        <tr>
                                            <td colspan="2">
												<span> Details </span>
												<br>
                                                <textarea  name="description" class="w580 h430" cols="50" rows="10" ><?php echo $sticky->get('description', $openingDBRow['description']); ?></textarea>
											</td>
                                        </tr>




                                    </table>



                                    <div class="button-container">
                                        <button class="form-button" type="submit" name="save" value="Save" onclick="this.setAttribute('value','Save');" ><span>Save</span></button>
                                        <a href="<?php echo $previousUrl; ?>">
                                            <button class="form-button" type="button" name="cancel"><span>Cancel</span></button>
                                        </a>
                                    </div>


                                    <!-- hidden fields -->
                                    <input type="hidden" name="organization_id" value="<?php echo $adminVO->organizationId ?>" />
                                    <input type="hidden" name="opening_id" value="<?php echo $openingId;  ?>" />

                                    <input type="hidden" name="updated_by" value="<?php echo $adminVO->email; ?>" />
                                    <input type="hidden" name="organization_name" value="<?php echo $adminVO->organizationName; ?>" />

                                    <div style="clear: both;"></div>

                                </form>
                            </div> <!-- form wrapper -->


                        </div> <!-- content -->
						
                    </div>
					<div class="yui3-u-1-3">
                        <?php include($_SERVER['APP_WEB_DIR'] . '/inc/sidebar.inc'); ?>

                    </div> <!-- u-1-3 -->


                </div> <!-- GRID -->


            </div> <!-- bd -->



        </div> <!-- body wrapper -->

        <div id="ft">
            <?php include($_SERVER['APP_WEB_DIR'] . '/inc/site-footer.inc'); ?>

        </div>

    </body>
</html>




