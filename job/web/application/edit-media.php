<?php
	include 'job-app.inc';
	//set the global variables
	include($_SERVER['APP_WEB_DIR'] . '/inc/header.inc');
	include($_SERVER['APP_WEB_DIR'] . '/inc/user/role.inc');


	use com\indigloo\common\Util ;
	use com\indigloo\common\ui\form\Sticky ;
	use com\mik3\Constants ;
	use com\indigloo\auth\FormAuthentication ;

	//attching media for this application.
	$applicationId = $gWeb->getRequestParam('g_application_id');
	Util::isEmpty('applicatonId', $applicationId);

	$applicationDao = new com\mik3\dao\Application();
	$applicationDBRow = $applicationDao->getRecordOnId($applicationId);
	$applicationHtml = com\mik3\html\template\Application::getUserSummary($applicationDBRow,array());

	//find document id and names
	$documentDBRows = $applicationDao->getDocuments($applicationId);
	$documentArray = array();
	foreach($documentDBRows as $documentDBRow){
		array_push($documentArray,array('id' => $documentDBRow['id'], 'name' => $documentDBRow['original_name']));
	}

	//json encode the $docs array
	// this value is written to docs_array element of form

	$documentArrayAsJson = json_encode($documentArray);
	//@todo fix json encoding issue - right now if we put this string as
	// frm.element.value = "json_string" then we have escaping issues since the json_string
	// itself contains double quotes.


	//find and destroy sticky map
	$sticky = new Sticky($gWeb->find(Constants::STICKY_MAP,true));
	//This method will throw an error
	$userVO = FormAuthentication::getLoggedInUser();


?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>

    <head><title> Attach  documents</title>

        <meta http-equiv="content-type" content="text/html; charset=ISO-8859-1" />
		
        <link rel="stylesheet" type="text/css" href="/css/grids-min.css">
		<!-- swfupload style interferes with our grids -->
        <!-- <link rel="stylesheet" type="text/css" href="/swfupload/default.css"> -->
		
        <link rel="stylesheet" type="text/css" href="/css/style.css">
		
        <!-- include any javascript here -->
        <script type="text/javascript" src="/js/jquery-1.6.2.min.js"></script>
        <script type="text/javascript" src="/js/jquery-ui-1.8.14.custom.min.js"></script>
        <script type="text/javascript" src="/js/json2.js"></script>
        <!-- main.js uses jquery and json -->
        <script type="text/javascript" src="/js/main.js"></script>

         <!-- swfupload related stuff -->
        <script type="text/javascript" src="/swfupload/swfupload.js"></script>
        <script type="text/javascript" src="/swfupload/js/swfupload.queue.js"></script>
        <script type="text/javascript" src="/swfupload/js/fileprogress.js"></script>
        <script type="text/javascript" src="/swfupload/js/handlers.js"></script>

        
        <script type="text/javascript">

           
            //attach events
            $(document).ready(function(){
                $("a.removeMedia").live("click", function(event){
                    event.preventDefault();
                    var docId = $(this).attr("id");
                    //remove flexi data
                    webgloo.gMedia.table.removeRow(docId);
                }) ;

                //initialize gMedia table with documentId coming from server
                webgloo.gMedia.debug = false ;
                webgloo.gMedia.table.load();


            });
            
            //swffileupload related javascript
            var swfu;
            /*
             * we have to consider following settings
             * 1. php.ini settings 
             *    memory_limit > post_max_size > upload_max_filesize
             * 2. nginx.conf client_mx_body_size
             * 3. swfupload limits (in this file)
             * 4. our max.file.size application setting in config.ini file
             * 
             */
            window.onload = function() {
                var settings = {
                    flash_url : "/swfupload/swfupload.swf",
                    upload_url: "/swfupload/receiver.php",
                    post_params: {
                        "PHPSESSID" : "<?php echo session_id(); ?>",
                        "entity_id" : "<?php echo $applicationId;  ?>",
                        "entity_name" : "APPLICATION"
                    },
                    file_size_limit : "100 MB",
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
                    
					button_image_url: "/swfupload/images/XPButtonUploadText_61x22.png",
                    button_width: "61",
                    button_height: "22",
                    button_placeholder_id: "spanButtonPlaceHolder",
					button_cursor:SWFUpload.CURSOR.HAND,
                    
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
								   <div class="fb_name navy floatl">Attach Documents </div>
							   
								   <div class="clear"></div>
							</div> <!-- fb_top -->
                           
                            <p class="help-text">
                                Attach documents for your application here.
                                <a href="/"> You can also attach the documents later.</a>
                            </p>
							
                            <div class="opening">
                                <!-- include application summary  -->
                                <?php echo $applicationHtml; ?>

                            </div>
                            

                            <h4 class="mt20"> Documents  </h4>
                            
                            <?php include($_SERVER['APP_WEB_DIR'] . '/inc/form/message.inc'); ?>

                            <div id="preview">
                                <table class="doc-table pt10">


                                </table>

                            </div>
                            <div id="form-wrapper">
                                <form id="web-form1" class="web-form" name="web-form1" action="/application/post/edit-media.php" enctype="multipart/form-data"  method="POST">

                                    <div class="error">    </div>

                                    <!-- file upload component  -->
                                    <div class="fieldset flash" id="fsUploadProgress">
                                        <span class="legend">Upload Queue</span>
                                    </div>
                                    <div id="divStatus">No Files Uploaded</div>
                                    <div class="pt10">
                                        <span id="spanButtonPlaceHolder"></span>
										<span>
											<input class="uploadCancelButton" id="btnCancel" type="button" value="Cancel Upload" onclick="swfu.cancelQueue();" disabled="disabled"/>
										</span>
										
                                    </div>

                                    <!-- hidden fields -->
                                    <input type="hidden" name="application_id" value="<?php echo $applicationId; ?>" />
                                    <input type="hidden" name="document_array_json" value='<?php echo $documentArrayAsJson; ?>' />
                                    
                                    <div style="clear: both;"></div>

                                </form>
                            </div> <!-- form wrapper -->


                        </div>

                    </div> <!-- main unit -->
                </div> <!-- GRID -->


            </div> <!-- bd -->



        </div> <!-- body wrapper -->

		<?php include($_SERVER['APP_WEB_DIR'] . '/inc/site-footer.inc'); ?>

    </body>
</html>
