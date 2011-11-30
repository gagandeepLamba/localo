<?php
	include 'news-app.inc';
	include($_SERVER['APP_WEB_DIR'] . '/inc/header.inc');
	

	use com\indigloo\Util ;
	use com\indigloo\ui\form\Sticky ;
	use com\indigloo\Constants as Constants ;
	
	$postId = $gWeb->getRequestParam('g_post_id');
	Util::isEmpty('postId', $postId);
	
	$postDao = new com\indigloo\news\dao\Post();
	$postDBRow = $postDao->getRecordOnId($postId);
	
	$mediaDao = new com\indigloo\news\dao\Media();
	$mediaDBRows = $mediaDao->getMediaOnPostId($postId);
	
	$mediaVOArray = array();
	foreach($mediaDBRows as $mediaDBRow) {
		$mediaVO = com\indigloo\news\view\Media::create($mediaDBRow);
		array_push($mediaVOArray,$mediaVO);
	}
									
	$mediaVOArrayJson = json_encode($mediaVOArray);
	
	$sticky = new Sticky($gWeb->find(Constants::STICKY_MAP,true));
	

?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>

    <head><title> Attach  documents</title>

        <meta http-equiv="content-type" content="text/html; charset=ISO-8859-1" />
		
        <link rel="stylesheet" type="text/css" href="/lib/yui3/grids-min.css">
		<!-- swfupload style interferes with our grids -->
        <!-- <link rel="stylesheet" type="text/css" href="/swfupload/default.css"> -->
		
        <link rel="stylesheet" type="text/css" href="/css/style.css">
        <script type="text/javascript" src="/lib/jquery/jquery-1.6.4.min.js"></script>
		<script type="text/javascript" src="/lib/json2.js"></script>
		<script type="text/javascript" src="/js/media.js"></script>
		
        <!-- swfupload related stuff -->
        <script type="text/javascript" src="/swfupload/swfupload.js"></script>
        <script type="text/javascript" src="/swfupload/js/swfupload.queue.js"></script>
        <script type="text/javascript" src="/swfupload/js/fileprogress.js"></script>
        <script type="text/javascript" src="/swfupload/js/handlers.js"></script>

        
        <script type="text/javascript">
			
            $(document).ready(function(){
				webgloo.media.debug = false ;
				webgloo.media.clearDebug();
				
				frm = document.forms["web-form1"];
				var strMediaVOArray = frm.media_vo_array.value ;
        
				if(strMediaVOArray.length > 0 ) {
					webgloo.media.addDebug( "media vo array json is ::  " + strMediaVOArray);
					//objectify
					var mediaVORows = JSON.parse(strMediaVOArray);
					for(i = 0 ;i < mediaVORows.length ; i++) {
						var mediaVO = mediaVORows[i];
						webgloo.media.addImage(mediaVO);
					}
					
				}

            });
			
            
			
            //swffileupload stuff
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
                        "entity_id" : "<?php echo $postId;  ?>",
                        "entity_name" : "POST"
                    },
                    file_size_limit : "8 MB",
                    file_types : "*.*",
                    file_types_description : "All Files",
                    file_upload_limit : 10,
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
				<?php include($_SERVER['APP_WEB_DIR'] . '/inc/banner.inc'); ?>
            </div>
            <div id="bd">

                <div class="yui3-g">
                  
                    <div class="yui3-u-2-3">
                        <div id="content">
							 <h2> Edit Photos &nbsp;&raquo; <?php echo $postDBRow['title']; ?> </h2>
							  <p class="help-text">
								<a href="/post/edit.php?g_post_id=<?php echo $postId; ?>"> Edit post details </a> | Edit Post Photos
                            </p>
							  
							
							
                             <div id="form-wrapper">
                                <form id="web-form1" class="web-form" name="web-form1" action="/post/edit-media.php" enctype="multipart/form-data"  method="POST">

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
                                    <input type="hidden" name="post_id" value="<?php echo $postId; ?>" />
                                    
                                    
                                    <div style="clear: both;"></div>
									<input type="hidden" name="media_vo_array" value='<?php echo $mediaVOArrayJson; ?>' />
									 
                                </form>
                            </div> <!-- form wrapper -->
							

                            <h4 class="mt20"> Photos  </h4>
							<div id="preview">
								<div class="yui3-u" id="preview1"> </div>
								<div class="yui3-u" id="preview2"> </div>
							</div>
							
                        </div> <!-- content -->

                    </div>
					
					<div class="yui3-u-1-3">
                        <?php include($_SERVER['APP_WEB_DIR'] . '/inc/sidebar.inc'); ?>
                    </div>


                </div> <!-- GRID -->


            </div> <!-- bd -->



        </div> <!-- body wrapper -->
		<div id="js-debug"> </div>
		
		<div id="ft">
            <?php include($_SERVER['APP_WEB_DIR'] . '/inc/site-footer.inc'); ?>
        </div>
    </body>
</html>
