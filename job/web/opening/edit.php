<?php
    include 'job-app.inc';
    include($_SERVER['APP_WEB_DIR'] . '/inc/header.inc');
    include($_SERVER['APP_LIB_DIR'] . '/error.inc');

    //check if user has customer admin role or not
    include($_SERVER['APP_WEB_DIR'] . '/inc/admin/role.inc');

    use webgloo\auth\FormAuthentication;
    use webgloo\job\html\Link;
    use webgloo\common\Url;
    use webgloo\common\Util ;
    use webgloo\common\ui\form\Sticky ;
    use webgloo\job\Constants ;
    use webgloo\job\html\UIData ;

    //This method will throw an error
    $adminVO = FormAuthentication::getLoggedInAdmin();
    $organizationId = $adminVO->organizationId;

    //find and destroy sticky map
    $sticky = new Sticky($gWeb->find(Constants::STICKY_MAP,true));
    $openingId = $gWeb->getRequestParam('g_opening_id');
    Util::isEmpty('openingId',$openingId);

    $openingDao = new webgloo\job\dao\Opening();
    $openingDBRow = $openingDao->getRecordOnId($openingId);

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

		
?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>

    <head><title> <?php echo $adminVO->company; ?> Job Openings</title>


        <meta http-equiv="content-type" content="text/html;" />

        <link rel="stylesheet" type="text/css" href="/css/grids-min.css">
        <link rel="stylesheet" type="text/css" href="/css/jquery/flick/jquery-ui-1.8.14.custom.css">
        <!-- app css here -->
        <link rel="stylesheet" type="text/css" href="/css/main.css">

        <script type="text/javascript" src="/js/jquery-1.6.2.min.js"></script>
        <!-- jquery UI and css -->
        <script type="text/javascript" src="/js/jquery-ui-1.8.14.custom.min.js"></script>
        <script type="text/javascript" src="/js/main.js"></script>


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
                    <div class="yui3-u-5-24">
                        <?php include($_SERVER['APP_WEB_DIR'] . '/inc/left-panel.inc'); ?>

                    </div> <!-- left unit -->


                    <div class="yui3-u-19-24">
                        <div id="main-panel">
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
                                                <input type="text" name="bounty" maxlength="6" class="required width-1" title="&gt;&nbsp;Bounty is a required field" value="<?php echo $sticky->get('bounty', $openingDBRow['bounty']); ?>"/>
                                            </td>
                                        </tr>

                                        <!-- location - fill in with default company location -->
                                        <tr>
                                            <td class="field"> Location<span class="red-label">*</span></td>
                                            <td>
                                                <input type="text" name="location" maxlength="32" class="required width-1" title="&gt;&nbsp;Location is a required field" value="<?php echo $sticky->get('location', $openingDBRow['location']); ?>"/>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="field"> Title<span class="red-label">*</span></td>
                                            <td>
                                                <input type="text" name="title" maxlength="100" class="required width-2" title="&gt;&nbsp;Title is a required field" value="<?php echo $sticky->get('title', $openingDBRow['title']); ?>"/>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td> &nbsp; </td>
                                            <td>  <span> Must have skills </span> <br> <textarea  name="skill" class="height-1 width-2" cols="50" rows="4" ><?php echo $sticky->get('skill', $openingDBRow['skill']); ?></textarea> </td>
                                        </tr>

                                        <tr>
                                            <td> &nbsp; </td>
                                            <td><span> Description </span> <br>  <textarea  name="description" class="width-2" cols="50" rows="10" ><?php echo $sticky->get('description', $openingDBRow['description']); ?></textarea> </td>
                                        </tr>




                                    </table>



                                    <div class="button-container">
                                        <button type="submit" name="save" value="Save" onclick="this.setAttribute('value','Save');" ><span>Save</span></button>
                                        <button type="button" name="cancel" onClick="javascript:go_back('http://www.test2.com');"><span>Cancel</span></button>
                                    </div>


                                    <!-- hidden fields -->
                                    <input type="hidden" name="organization_id" value="<?php echo $adminVO->organizationId ?>" />
                                    <input type="hidden" name="updated_by" value="<?php echo $adminVO->email; ?>" />
                                    <input type="hidden" name="organization_name" value="<?php echo $adminVO->company; ?>" />

                                    <div style="clear: both;"></div>

                                </form>
                            </div> <!-- form wrapper -->


                        </div>
                    </div> <!-- main unit -->
                </div> <!-- GRID -->


            </div> <!-- bd -->



        </div> <!-- body wrapper -->

        <div id="ft">
            <?php include($_SERVER['APP_WEB_DIR'] . '/inc/site-footer.inc'); ?>

        </div>

    </body>
</html>




