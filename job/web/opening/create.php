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

    $comboValues = array ( '2W' => 'Two Weeks', '1M' => 'One Month', '2M' => 'Two Months');
    $comboBox = Html\ComboBox::render('expire_on',$comboValues, '1M') ;

    //find and destroy sticky map
    $sticky = new Sticky($gWeb->find(Constants::STICKY_MAP,true));

    //This method will throw an error
    $adminVO = FormAuthentication::getLoggedInAdmin();
    $previousUrl = $gWeb->getPreviousUrl();
    
    
?>



<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>

    <head><title> Post a job</title>

        <meta http-equiv="content-type" content="text/html; charset=ISO-8859-1" />

        <link rel="stylesheet" type="text/css" href="/css/grids-min.css">
        <link rel="stylesheet" type="text/css" href="/css/style.css">

        <!-- app css here -->
        <!-- include any javascript here -->
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
                    <div class="yui3-u-5-24">
                        <?php include($_SERVER['APP_WEB_DIR'] . '/inc/left-panel.inc'); ?>
                    </div> <!-- left unit -->
                    <div class="yui3-u-19-24">

                        <div id="main-panel">
                            <h2> Post a job </h2>


                            <p class="help-text">
                                Please fill in the details below and post your job opening.

                            </p>
                            <?php include($_SERVER['APP_WEB_DIR'] . '/inc/form/message.inc'); ?>


                            <div id="form-wrapper">
                                <form id="web-form1" class="web-form" name="web-form1" action="/opening/post/create.php" enctype="multipart/form-data"  method="POST">

                                    <div class="error">    </div>

                                    <table class="form-table">


                                        <tr>
                                            <td class="field"> Bounty<span class="red-label">*</span></td>
                                            <td>
                                                <input type="text" name="bounty" maxlength="6" class="required width-1" title="&gt;&nbsp;Bounty is a required field" value="<?php echo $sticky->get('bounty','10000'); ?>"/>
                                            </td>
                                        </tr>

                                         <tr>
                                            <td> Valid for</td>
                                            <td> <?php echo $comboBox;  ?> </td>
                                        </tr>
                                        
                                        <!-- location - fill in with default company location -->
                                        <tr>
                                            <td class="field"> Location<span class="red-label">*</span></td>
                                            <td>
                                                <input type="text" name="location" maxlength="32" class="required width-1" title="&gt;&nbsp;Location is a required field" value="<?php echo $sticky->get('location', 'Bangalore'); ?>"/>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="field"> Title<span class="red-label">*</span></td>
                                            <td>
                                                <input type="text" name="title" maxlength="100" class="required width-2" title="&gt;&nbsp;Title is a required field" value="<?php echo $sticky->get('title'); ?>"/>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="field"> Experience</td>
                                            <td>
                                                <input type="text" name="min_experience" class="width-number" maxlength="2" value="<?php echo $sticky->get('min_experience','1'); ?>"/>
                                                &nbsp;to&nbsp;
                                                <input type="text" name="max_experience" class="width-number" maxlength="2" value="<?php echo $sticky->get('max_experience','3'); ?>"/>
                                                &nbsp;years&nbsp;

                                            </td>

                                        </tr>

                                        <tr>
                                            <td> &nbsp; </td>
                                            <td>  <span> Desired skills </span> <br> <textarea  name="skill" class="height-1 width-2" cols="50" rows="4" ><?php echo $sticky->get('skill'); ?></textarea> </td>
                                        </tr>

                                        <tr>
                                            <td> &nbsp; </td>
                                            <td><span> Details (about this opportunity) </span> <br>  <textarea  name="description" class="width-2" cols="50" rows="10" ><?php echo $sticky->get('description'); ?></textarea> </td>
                                        </tr>




                                    </table>

                                    <div class="tc">
                                        By posting information here you agree to the <a href="/help/tc.php" target="_blank"> Terms and Conditions </a>
                                        imposed by this website. Please read them carefully.
                                    </div>
            

                                    <div class="button-container">
                                        <button class="form-button" type="submit" name="save" value="Save" onclick="this.setAttribute('value','Save');" ><span>Save</span></button>
                                        <a href="<?php echo $previousUrl; ?>">
                                            <button class="form-button"  type="button" name="cancel"><span>Cancel</span></button>
                                        </a>
                                    </div>


                                    <!-- hidden fields -->
                                    <input type="hidden" name="organization_id" value="<?php echo $adminVO->organizationId ?>" />
                                    <input type="hidden" name="created_by" value="<?php echo $adminVO->email; ?>" />
                                    <input type="hidden" name="organization_name" value="<?php echo $adminVO->organizationName; ?>" />

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
