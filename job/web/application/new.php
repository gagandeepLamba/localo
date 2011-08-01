<?php
include 'job-app.inc';
//set the global variables
include($_SERVER['APP_WEB_DIR'] . '/inc/header.inc');
include($_SERVER['APP_WEB_DIR'] . '/inc/user/role.inc');

use webgloo\common\Util ;
use webgloo\common\ui\form\Sticky ;
use webgloo\job\Constants ;
use webgloo\auth\FormAuthentication ;

$organizationId = $gWeb->getRequestParam('g_org_id');
Util::isEmpty('organizationId', $organizationId);

$openingId = $gWeb->getRequestParam('g_opening_id');
Util::isEmpty('openingId', $openingId);

$openingDao = new webgloo\job\dao\Opening();
$openingDBRow = $openingDao->getRecordOnId($openingId);
$openingHtml = webgloo\job\html\template\Opening::getUserSummary($openingDBRow);

//find and destroy sticky map
$sticky = new Sticky($gWeb->find(Constants::STICKY_MAP,true));
//This method will throw an error
$userVO = FormAuthentication::getLoggedInUser();


?>



<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>

    <head><title> Application for job - <?php echo $openingDBRow['title']; ?> </title>
        
        <meta http-equiv="content-type" content="text/html; charset=ISO-8859-1" />

        <link rel="stylesheet" type="text/css" href="/css/grids-min.css">
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

                                    
                                     <div>
                                        <!-- include opening details -->
                                        <?php  echo $openingHtml; ?>
                                            
                                    </div>

                                    <h2> Send Application </h2>
                                    <p class="help-text">
                                       Please fill in the details below and post your job opening.

                                    </p>
                                    <?php include($_SERVER['APP_WEB_DIR'] . '/inc/form/message.inc'); ?>
                                    

                                    <div id="form-wrapper">
                                        <form id="web-form1" class="web-form" name="web-form1" action="/application/post/new.php" enctype="multipart/form-data"  method="POST">

                                            <div class="error">    </div>

                                            <table class="form-table">
                                                <tr>
                                                    <td class="field"> Name<span class="red-label">*</span></td>
                                                    <td>
                                                        <input type="text" name="cv_name" maxlength="128" class="required" title="&gt;&nbsp;Name is a required field" value="<?php echo $sticky->get('cv_name'); ?> "/>
                                                    </td>
                                                </tr>

                                                 <tr>
                                                    <td class="field"> Email<span class="red-label">*</span></td>
                                                    <td>
                                                        <input type="text" name="cv_email" maxlength="128" class="required" title="&gt;&nbsp;Email is a required field" value="<?php echo $sticky->get('cv_email'); ?>"/>
                                                    </td>
                                                </tr>

                                                 <tr>
                                                    <td class="field"> Phone<span class="red-label">*</span></td>
                                                    <td>
                                                        <input type="text" name="cv_phone" maxlength="16" class="required" title="&gt;&nbsp;Phone is a required field" value="<?php echo $sticky->get('cv_phone'); ?>"/>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td class="field"> Education<span class="red-label">*</span></td>
                                                    <td>
                                                        <input type="text" name="cv_education" maxlength="128" class="required" title="&gt;&nbsp;Phone is a required field" value="<?php echo $sticky->get('cv_education'); ?>"/>
                                                    </td>
                                                </tr>

                                                 <tr>
                                                    <td class="field">Title (blank for freshers)</td>
                                                    <td>
                                                        <input type="text" name="cv_title" maxlength="128" value="<?php echo $sticky->get('cv_title'); ?>"/>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td class="field"> Company</td>
                                                    <td>
                                                        <input type="text" name="cv_company" maxlength="128" value="<?php echo $sticky->get('cv_company'); ?>"/>
                                                    </td>
                                                </tr>
                                                
                                                <!-- location - fill in with  candidate location -->
                                                 <tr>
                                                    <td class="field"> Location<span class="red-label">*</span></td>
                                                    <td>
                                                        <input type="text" name="cv_location" maxlength="32" class="required" title="&gt;&nbsp;Location is a required field" value="<?php echo $sticky->get('cv_location','Bangalore'); ?>"/>
                                                    </td>
                                                </tr>

                                                
                                            </table>

                                            <br>
                                            

                                            <span> Description (why you recommend this candidate) </span>
                                            <div class="text-container">
                                                <textarea  name="cv_description" cols="50" rows="10" ><?php echo $sticky->get('cv_description'); ?></textarea>
                                            </div>


                                            <span> Skills </span>
                                            <div class="text-container">
                                                <textarea  name="cv_skill" cols="50" rows="4" ><?php echo $sticky->get('cv_skill'); ?></textarea>
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
                                            <input type="hidden" name="organization_id" value="<?php echo $organizationId; ?>" />
                                            <input type="hidden" name="forwarder_email" value="<?php echo $userVO->email ; ?>" />
                                            <input type="hidden" name="user_id" value="<?php echo $userVO->uuid ; ?>" />
                                            <input type="hidden" name="opening_id" value="<?php echo $openingId ; ?>" />

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
