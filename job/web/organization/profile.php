<?php
    include ('job-app.inc');
    include($_SERVER['APP_WEB_DIR'] . '/inc/header.inc');
    //check if user has customer admin role or not
    include($_SERVER['APP_WEB_DIR'] . '/inc/admin/role.inc');

    use com\indigloo\common\Util;
    use com\indigloo\common\ui\form\Sticky;
    use com\mik3\Constants;
    use com\indigloo\auth\FormAuthentication;
    use com\mik3\html as Html;
    
    //find and destroy sticky map
    $sticky = new Sticky($gWeb->find(Constants::STICKY_MAP,true));

    //This method will throw an error
    $adminVO = FormAuthentication::getLoggedInAdmin();
    
    $organizationDao = new com\mik3\dao\Organization();
    $organization = $organizationDao->getRecordOnId($adminVO->organizationId);
    //sanity check
    $organizationDao->checkNull($organization);
    
    $previousUrl = $gWeb->getPreviousUrl();
    
    
?>



<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>

    <head><title> Organization Details</title>

        <meta http-equiv="content-type" content="text/html; charset=ISO-8859-1" />

        <link rel="stylesheet" type="text/css" href="/css/grids-min.css">
        <link rel="stylesheet" type="text/css" href="/css/style.css">
        
        <script type="text/javascript" src="/js/jquery-1.6.2.min.js"></script>
        <script type="text/javascript" src="/js/jquery.validate.min.js"></script>

        <script type="text/javascript">
            $(document).ready(function(){
                //form validator
                $("#web-form1").validate({
                    errorLabelContainer: $("#web-form1 div.error")
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
                             <div class="fb_top">
                                    <div class="fb_name navy floatl">Organization Profile</div>
								
                                    <div class="clear"></div>
                                </div> <!-- fb_top -->

                            <p class="help-text">
                                Please fill in the details below and click on Save.

                            </p>
                            <?php include($_SERVER['APP_WEB_DIR'] . '/inc/form/message.inc'); ?>


                            <div id="form-wrapper">
                                <form id="web-form1" class="web-form" name="web-form1" action="/organization/post/profile.php" enctype="multipart/form-data"  method="POST">

                                    <div class="error">    </div>

                                    <table class="form-table">


                                        <tr>
                                            <td class="field"> Name<span class="red-label">*</span></td>
                                            <td>
                                                <input type="text" name="name" maxlength="100" class="required" title="&gt;&nbsp;name is a required field" value="<?php echo $sticky->get('name', $organization['name']); ?>"/>
                                            </td>
                                        </tr>

                                         <tr>
                                            <td class="field"> Website<span class="red-label">*</span></td>
                                            <td>
                                                <input type="text" name="website" maxlength="100" class="required" title="&gt;&nbsp;website is a required field" value="<?php echo $sticky->get('website', $organization['domain']); ?>"/>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td colspan="2">
                                                <span> About us</span> <br>
                                                <textarea  name="description" class="h430 w580" cols="50" rows="10" ><?php echo $sticky->get('description',$organization['description']); ?></textarea>
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
                                    <div style="clear: both;"></div>

                                </form>
                            </div> <!-- form wrapper -->


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
