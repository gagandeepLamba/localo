<?php

    //qa/edit.php
    include ('sc-app.inc');
    include($_SERVER['APP_WEB_DIR'] . '/inc/header.inc');
    include($_SERVER['APP_WEB_DIR'] . '/inc/auth.inc');
	 
    use com\indigloo\Util;
    use com\indigloo\ui\form\Sticky;
    use com\indigloo\Constants as Constants;
    use com\indigloo\ui\form\Message as FormMessage;
     
    $sticky = new Sticky($gWeb->find(Constants::STICKY_MAP,true));
    
    $noteId = NULL ;
    if(!array_key_exists('id',$_GET)) {
        trigger_error('REQ missing id',E_USER_ERROR);
    } else {
        $noteId = $_GET['id'];
    }
    
    
    $noteDao = new com\indigloo\sc\dao\Note();
    $noteDBRow = $noteDao->getOnId($noteId);
    $imagesJson = $noteDBRow['images_json'];
    
    
    
?>  

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>

       <head><title> Edit Question</title>
         

        <meta http-equiv="content-type" content="text/html; charset=ISO-8859-1" />

        <link rel="stylesheet" type="text/css" href="/3p/yui3/grids-min.css">
        <link rel="stylesheet" type="text/css" href="/css/sc.css">
        
        <script type="text/javascript" src="/3p/jquery/jquery-1.6.4.min.js"></script>
        <script type="text/javascript" src="/3p/jquery/jquery.validate.1.9.0.min.js"></script>
        <script type="text/javascript" src="/js/sc.js"></script>
        
       
       <!-- swfupload related stuff -->
        <script type="text/javascript" src="/3p/swfupload/swfupload.js"></script>
        <script type="text/javascript" src="/3p/swfupload/js/swfupload.queue.js"></script>
        <script type="text/javascript" src="/3p/swfupload/js/fileprogress.js"></script>
        <script type="text/javascript" src="/3p/swfupload/js/handlers.js"></script>
        
        <script type="text/javascript">
       
            $(document).ready(function(){
                
                $("#web-form1").validate({
                    errorLabelContainer: $("#web-form1 div.error")
                    
                });
                
                webgloo.sc.question.attachEvents();
                webgloo.sc.question.init();
            });
       
              
              
            var swfu;
            
            window.onload = function() {
                var settings = {
                    flash_url : "/3p/swfupload/swfupload.swf",
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

                                    <h2> Ask Anything </h2>


                                    <p class="help-text">
                                       Please provide details below and post your question.

                                    </p>
                                    
                                    <?php FormMessage::render(); ?>
                            
                                    <div id="form-wrapper">
                                        <form id="web-form1"  name="web-form1" action="/qa/form/edit.php" enctype="multipart/form-data"  method="POST">

                                            <div class="error">    </div>

                                            <table class="form-table">

                                                 <tr>
                                                    <td class="field">Question<span class="red-label">*</span></td>
                                                    <td>
                                                        <input type="text" name="title" maxlength="128" class="required" title="&gt; Queston is required"! value="<?php echo $sticky->get('question',$noteDBRow['title']); ?>"/>
                                                    </td>
                                                 </tr>
                                                 <tr>
                                                    <td class="field">Privacy<span class="red-label">*</span> &nbsp;</td>
                                                    <td>
                                                        <select name="privacy">
															   <option value="PUB">Public</option>
                                                               <option value="FRND">Friends</option>
                                                               <option value="CARF">Car Fans</option>
															   <option value="HSRR">HSR Retail Club</option>
                                                               
                                                        </select>
                                                    </td>
                                                </tr>
												 
                                                 <tr>
                                                        <td class="field">Details</td>
                                                        <td>
                                                            <textarea  name="description" class="h130" cols="50" rows="4" ><?php echo $sticky->get('description',$noteDBRow['description']); ?></textarea>
                                                        </td>
                                                 </tr>
                                                 <tr>
                                                    <td class="field">Location<span class="red-label">*</span> &nbsp; </td>
                                                    <td> <input type="text" name="location" maxlength="32" class="w200 required" minlength="3" title="&gt; Location is required!" value="<?php echo $sticky->get('location',$userDBRow['location']); ?>" /></td>
                                                </tr>
                                                 
                                                 <tr>
                                                    <td class="field">Category<span class="red-label">*</span> &nbsp;</td>
                                                    <td>
                                                        <select name="category">
															   <option value="Baby">Baby</option>
                                                               <option value="Bags">Bags</option>
                                                               <option value="Camera">Camera</option>
															   <option value="Cars">Cars</option>
                                                               <option value="Clothes">Clothes</option>
                                                               <option value="Computers">Computers</option>
															   <option value="Home">Home</option>
															   <option value="Mobile">Mobile</option>
															   <option value="Other">Other</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                                 <tr>
                                                        <td class="field">&nbsp;</td>
                                                        <td>
                                                            Send deals? <input type="checkbox" style="width:30px;vertical-align:middle;" class="small-checkbox" name="send_deal" value="1" /> Yes!
                                                        </td>
                                                 </tr>
												 
                                                <tr>
                                                    <td class="field">Tags<span class="red-label">*</span> &nbsp;</td>
                                                    <td> <input  type="text" name="tags" maxlength="64" class="required"  title="&gt; Tags are required!" value="<?php echo $sticky->get('description',$noteDBRow['tags']); ?>" /></td>
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
                                            <input type="hidden" name="links_json" value="" />
                                            <input type="hidden" name="images_json" value='<?php echo $noteDBRow['images_json'] ; ?>' />
                                            <input type="hidden" name="note_id" value="<?php echo $noteDBRow['id'] ; ?>" />
                                            <input type="hidden" name="entity_type" value="QUE" />
											
                                        </form>
                                    </div> <!-- form wrapper -->
                                   
                                   
                            </div> <!-- content -->


                        </div> <!-- u-2-3 -->
                        
                         <div class="yui3-u-1-3">
                            <!-- sidebar -->
                        </div> <!-- u-1-3 -->
                        
                    </div> <!-- GRID -->


                </div> <!-- bd -->


              <div id="js-debug"> </div>
              
              
        </div> <!-- body wrapper -->
        <div id="ft">
            <?php include($_SERVER['APP_WEB_DIR'] . '/inc/site-footer.inc'); ?>
        </div>

    </body>
</html>
