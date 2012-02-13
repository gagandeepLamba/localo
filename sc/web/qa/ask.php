<?php

    //qa/ask.php
    include ('sc-app.inc');
    include($_SERVER['APP_WEB_DIR'] . '/inc/header.inc');
    include($_SERVER['APP_WEB_DIR'] . '/inc/role/user.inc');
	 
    use com\indigloo\Util;
    use com\indigloo\ui\form\Sticky;
    use com\indigloo\Constants as Constants;
    use com\indigloo\ui\form\Message as FormMessage;
     
    $sticky = new Sticky($gWeb->find(Constants::STICKY_MAP,true));
    
    $strImagesJson = $sticky->get('images_json') ;
    $strLinksJson = $sticky->get('links_json') ;
    
    $strImagesJson = empty($strImagesJson) ? '[]' : $strImagesJson ;
    $strLinksJson = empty($strLinksJson) ? '[]' : $strLinksJson ;

    
?>  

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>

       <head><title> Ask Anything</title>
         

       <meta http-equiv="content-type" content="text/html; charset=ISO-8859-1" />

       <link rel="stylesheet" type="text/css" href="/3p/yui3/grids-min.css">
       <link rel="stylesheet" type="text/css" href="/css/sc.css">
        
       <script type="text/javascript" src="/3p/jquery/jquery-1.6.4.min.js"></script>
       <script type="text/javascript" src="/3p/jquery/jquery.validate.1.9.0.min.js"></script>
       <script type="text/javascript" src="/js/sc.js"></script>
	   
	   <!-- autocomplete plugin -->
       <link rel="stylesheet" type="text/css" href="/3p/autocomplete/dyve/jquery.autocomplete.css">
	   <script type="text/javascript" src="/3p/autocomplete/dyve/jquery.autocomplete.js" ></script>
       
       <!-- swfupload related stuff -->
        <script type="text/javascript" src="/3p/swfuploadv2.5b3/swfupload.js"></script>
        <script type="text/javascript" src="/3p/swfuploadv2.5b3/js/swfupload.queue.js"></script>
        <script type="text/javascript" src="/3p/swfupload/js/fileprogress.js"></script>
        <script type="text/javascript" src="/3p/swfupload/js/handlers.js"></script>
        
        <script type="text/javascript">
       
            $(document).ready(function(){
                
              $("#web-form1").validate({
					 errorLabelContainer: $("#web-form1 div.error") 
              });
                
              webgloo.sc.question.attachEvents();
			  webgloo.sc.question.init();

			  $("#ac3").autocomplete({
					 data: [
							['bangalore', 1],
							['chennai', 2],
							['delhi', 3],
							['kolkata',4],
							['hyderabad',5],
							['mumbai', 6],
							['calcutta', 7]
						]
			  });

            });
       
              
              
            var swfu;
            
            window.onload = function() {
              var settings = {
			  flash_url : "/3p/swfuploadv2.5b3/swfupload.swf",
			  flash9_url : "/3p/swfuploadv2.5b3/swfupload_fp9.swf",
			  upload_url: "/test/receiver.php",
			  post_params: {
				  "PHPSESSID" : "<?php echo session_id(); ?>"
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
			  
			  button_image_url: "/3p/swfupload/images/XPButtonUploadText_61x22.png",
			  button_width: "61",
			  button_height: "22",
			  button_placeholder_id: "spanButtonPlaceHolder",
			  button_cursor:SWFUpload.CURSOR.HAND,
			  
			  // handlers.js event handlers
			  file_queued_handler : fileQueued,
			  file_queue_error_handler : fileQueueError,
			  file_dialog_complete_handler : fileDialogComplete,
			  upload_start_handler : uploadStart,
			  upload_progress_handler : uploadProgress,
			  upload_error_handler : uploadError,
			  upload_success_handler : webgloo.sc.question.uploadSuccess,
			  upload_complete_handler : uploadComplete,
			  queue_complete_handler : queueComplete
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

                                    <h2> Ask your Question </h2>


                                    <p class="help-text">
                                      &nbsp;

                                    </p>
                                    
                                    <?php FormMessage::render(); ?>
                            
                                    <div id="form-wrapper">
                                        <form id="web-form1"  name="web-form1" action="/qa/form/ask.php" enctype="multipart/form-data"  method="POST">

                                            <div class="error">    </div>

                                            <table class="form-table">

                                                 <tr>
                                                    <td class="field">Question<span class="red-label">*</span></td>
                                                    <td>
                                                        <input type="text" name="title" maxlength="128" class="required" title="&gt; Queston is required"! value="<?php echo $sticky->get('title'); ?>"/>
                                                    </td>
                                                 </tr>
												  <tr>
                                                    <td class="field">Category<span class="red-label">*</span> &nbsp;</td>
                                                    <td>
														<?php
														    $selectBoxDao = new \com\indigloo\sc\dao\SelectBox();
														    $catRows = $selectBoxDao->get('CATEGORY');
															echo \com\indigloo\ui\SelectBox::render('category',$catRows);	   	   
																													
														?>
														
                                                    </td>
                                                </tr>
                                                 <tr>
														<td class="field">Details</td>
														<td>
															<textarea  name="description" class="h130" cols="50" rows="4" ><?php echo $sticky->get('description'); ?></textarea>
														</td>
                                                 </tr>
                                                 <tr>
                                                    <td class="field">Location</td>
                                                    <td> <input id="ac3" type="text" name="location" maxlength="32" class="w200" value="<?php echo $sticky->get('location'); ?>" /></td>
                                                </tr>
                                          
                                                <tr>
                                                    <td class="field">Tags<span class="red-label">*</span> &nbsp;</td>
                                                    <td> <input  type="text" name="tags" maxlength="64" class="required"  title="&gt; Tags are required!" value="<?php echo $sticky->get('tags'); ?>" /></td>
                                                </tr>
                                                 
                                                <tr>
                                                 <td> &nbsp; </td>
                                                 <td>
                                                        <a id="open-link" href="">Add Link</a>
                                                        &nbsp;
                                                        <a id="open-image" href="">Add Image</a> 
                                                 </td>
                                                 
                                                </tr>
                                                 <tr>
                                                 <td> &nbsp; </td>
                                                 <td>
                                                        <div id="link-data"> </div>
                                                        <div id="media-data"> </div>
                                                 </td>
                                                 
                                                </tr>
                                                
                                            </table>
                                            <hr>
                                           
                                       
                                          <div id="link-container" class="hide-me">
                                            <div id="error"> </div>
                                            <p> Use a url shortening service like goo.gl to shorten long urls</p>
                                            Link*&nbsp;<input  id="link-box"  type="text" name="link"  value="" />
                                            &nbsp; <button  id="add-link">Add</button>
                                            
                                          </div>
                                          
                                          
                                          <div id="image-container" class="hide-me">
                                                 <p>
                                                 Click upload and select photos to add.
                                                 </p>
                                                 <div class="fieldset flash" id="fsUploadProgress">
                                                     <span class="legend">Upload Queue</span>
                                                 </div>
                                                 <br />
                                                 
                                                 <div id="divStatus">&nbsp;</div>
                                                 <div>
                                                     <span id="spanButtonPlaceHolder"></span>
                                                     <span>
                                                         <input class="uploadCancelButton" id="btnCancel" type="button" value="Cancel Upload" onclick="swfu.cancelQueue();" disabled="disabled"/>
                                                     </span>
                                                     
                                                 </div>
                                                 
                                          </div>
                                             
                                            <div class="button-container">
                                                <button class="form-button" type="submit" name="save" value="Save" onclick="this.setAttribute('value','Save');" ><span>Save</span></button>
                                                 <a href="/">
                                                    <button class="form-button" type="button" name="cancel"><span>Cancel</span></button>
                                                </a>
                                                
                                            </div>
                                            
                                            <div style="clear: both;"></div>
                                            <input type="hidden" name="links_json" value='<?php echo $strLinksJson ; ?>' />
                                            <input type="hidden" name="images_json" value='<?php echo $strImagesJson ; ?>' />
                                            <input type="hidden" name="entity_type" value="QUE" />
											
                                        </form>
                                    </div> <!-- form wrapper -->
                                   
                                   
                            </div> <!-- content -->


                        </div> 
                        
                         <div class="yui3-u-1-3">
                             <?php include('sidebar/ask.inc'); ?>
                        </div> 
                        
                    </div> 


                </div> <!-- bd -->


              <div id="js-debug"> </div>
              
              
        </div> <!-- body wrapper -->
        <div id="ft">
            <?php include($_SERVER['APP_WEB_DIR'] . '/inc/site-footer.inc'); ?>
        </div>

    </body>
</html>
