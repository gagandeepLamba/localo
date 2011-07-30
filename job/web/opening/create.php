<?php
include ('job-app.inc');
include($_SERVER['APP_WEB_DIR'] . '/inc/header.inc');
//check if user has customer admin role or not
include($_SERVER['APP_WEB_DIR'] . '/inc/admin/role.inc');


use webgloo\common\Util ;
use webgloo\common\ui\form\Sticky ;
use webgloo\job\Constants ;
use webgloo\auth\FormAuthentication ;

//find and destroy sticky map
$sticky = new Sticky($gWeb->find(Constants::STICKY_MAP,true));
//This method will throw an error
$adminVO = FormAuthentication::getLoggedInAdmin();


?>



<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>

    <head><title> Post a job opening </title>
        
        <meta http-equiv="content-type" content="text/html; charset=ISO-8859-1" />

        <link rel="stylesheet" type="text/css" href="http://yui.yahooapis.com/3.3.0/build/cssgrids/grids-min.css">
        <link rel="stylesheet" type="text/css" href="/css/main.css">
        
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



                                    <div id="form-wrapper">
                                        <form id="web-form1" class="web-form" name="web-form1" action="/opening/post/create.php" enctype="multipart/form-data"  method="POST">

                                            <div class="error">    </div>

                                            <table class="form-table">
                                                <tr>
                                                    <td class="field"> Title<span class="red-label">*</span></td>
                                                    <td>
                                                        <input type="text" name="title" maxlength="100" class="required" title="&gt;&nbsp;Title is a required field" value=""/>
                                                    </td>
                                                </tr>

                                                 <tr>
                                                    <td class="field"> Bounty<span class="red-label">*</span></td>
                                                    <td>
                                                        <input type="text" name="bounty" maxlength="10" class="required" title="&gt;&nbsp;Bounty is a required field" value="1000"/>
                                                    </td>
                                                </tr>
                                                <!-- location - fill in with default company location -->
                                                 <tr>
                                                    <td class="field"> Location<span class="red-label">*</span></td>
                                                    <td>
                                                        <input type="text" name="location" maxlength="32" class="required" title="&gt;&nbsp;Location is a required field" value="Bangalore"/>
                                                    </td>
                                                </tr>

                                                
                                            </table>

                                            <br>
                                            

                                            <span> Description </span>
                                            <div class="text-container">
                                                <textarea  name="description" cols="50" rows="10" ></textarea>
                                            </div>


                                            <span> Must have skills </span>
                                            <div class="text-container">
                                                <textarea  name="skill" cols="50" rows="4" ></textarea>
                                            </div>
                                            

                                            <div class="button-container">

                                                <div class="submit">
                                                    <div>
                                                        <button type="submit" name="save" value="Save" onclick="this.setAttribute('value','Save');" ><span>Save</span></button>
                                                    </div>
                                                </div>

                                                <div class="button">
                                                    <div>
                                                        <button type="button" name="cancel" onClick="javascript:go_back('http://www.test2.com');"><span>Cancel</span></button>
                                                    </div>
                                                </div>

                                            </div>


                                            <!-- hidden fields -->
                                            <input type="hidden" name="organization_id" value="<?php echo $adminVO->organizationId ?>" />
                                            <input type="hidden" name="created_by" value="<?php echo $adminVO->email; ?>" />
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
