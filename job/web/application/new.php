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

        <link rel="stylesheet" type="text/css" href="http://yui.yahooapis.com/3.3.0/build/cssgrids/grids-min.css">
        <link rel="stylesheet" type="text/css" href="/css/main.css">
        
        <!-- app css here -->
        <!-- include any javascript here -->
        <script type="text/javascript" src="/js/jquery-1.6.2.min.js"></script>
        <script type="text/javascript" src="/js/jquery.validate.min.js"></script>
        <script type="text/javascript" src="/js/json2.js"></script>

        <!-- swfupload related stuff -->
        <link href="/swfupload/default.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="/swfupload/swfupload.js"></script>
        <script type="text/javascript" src="/swfupload/js/swfupload.queue.js"></script>
        <script type="text/javascript" src="/swfupload/js/fileprogress.js"></script>
        <script type="text/javascript" src="/swfupload/js/handlers.js"></script>

        <script type="text/javascript">
            $(document).ready(function(){
                //form validator
                $("#web-form1").validate({
                    errorLabelContainer: $("#web-form1 div.error")
                });

            });

            //swffileupload related javascript
            var swfu;

		window.onload = function() {
			var settings = {
				flash_url : "/swfupload/swfupload.swf",
				upload_url: "/swfupload/receiver.php",
				post_params: {"PHPSESSID" : "<?php echo session_id(); ?>"},
				file_size_limit : "10 MB",
				file_types : "*.*",
				file_types_description : "All Files",
				file_upload_limit : 100,
				file_queue_limit : 0,
				custom_settings : {
					progressTarget : "fsUploadProgress",
					cancelButtonId : "btnCancel"
				},
				debug: false,

				// Button settings
				button_image_url: "/swfupload/images/TestImageNoText_65x29.png",
				button_width: "65",
				button_height: "29",
				button_placeholder_id: "spanButtonPlaceHolder",
				button_text: '<span class="theFont">Upload</span>',
				button_text_style: ".theFont { font-size: 16; }",
				button_text_left_padding: 12,
				button_text_top_padding: 3,

				// The event handler functions are defined in handlers.js
				file_queued_handler : fileQueued,
				file_queue_error_handler : fileQueueError,
				file_dialog_complete_handler : fileDialogComplete,
				upload_start_handler : uploadStart,
				upload_progress_handler : uploadProgress,
				upload_error_handler : uploadError,
				upload_success_handler : uploadSuccess,
				upload_complete_handler : uploadComplete,
				queue_complete_handler : queueComplete	// Queue plugin event
			};

			swfu = new SWFUpload(settings);
	     };

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

                                    <h2> Send Application </h2>
                                     <div>
                                        <!-- include opening details -->
                                        <?php  echo $openingHtml; ?>
                                            
                                    </div>

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

                                            <!-- file upload component  -->
                                            <div class="fieldset flash" id="fsUploadProgress">
                                                <span class="legend">Upload Queue</span>
                                            </div>
                                            <div id="divStatus">0 Files Uploaded</div>
                                            <div>
                                                    <span id="spanButtonPlaceHolder"></span>
                                                    <input id="btnCancel" type="button" value="Cancel All Uploads" onclick="swfu.cancelQueue();" disabled="disabled" style="margin-left: 2px; font-size: 8pt; height: 29px;" />
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
