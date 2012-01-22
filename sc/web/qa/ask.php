<?php

    //user/register.php
    include ('sc-app.inc');
    include($_SERVER['APP_WEB_DIR'] . '/inc/header.inc');
    
    use com\indigloo\Util;
    use com\indigloo\ui\form\Sticky;
    use com\indigloo\Constants as Constants;
    use com\indigloo\ui\form\Message as FormMessage;
     
    $sticky = new Sticky($gWeb->find(Constants::STICKY_MAP,true));
    
    
?>  

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>

       <head><title> Ask Anything</title>
         

        <meta http-equiv="content-type" content="text/html; charset=ISO-8859-1" />

        <link rel="stylesheet" type="text/css" href="/lib/yui3/grids-min.css">
        <link rel="stylesheet" type="text/css" href="/css/style.css">
        
        <script type="text/javascript" src="/lib/jquery/jquery-1.6.4.min.js"></script>
        <script type="text/javascript" src="/lib/jquery/jquery.validate.1.9.0.min.js"></script>
       <script type="text/javascript" src="/js/sc.js"></script>
        <!-- fancybox -->
        <script type="text/javascript" src="/lib/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
        <link rel="stylesheet" href="/lib/fancybox/jquery.fancybox-1.3.4.css" type="text/css" media="screen" />
        
       <!-- swfupload related stuff -->
        <script type="text/javascript" src="/swfupload/swfupload.js"></script>
        <script type="text/javascript" src="/swfupload/js/swfupload.queue.js"></script>
        <script type="text/javascript" src="/swfupload/js/fileprogress.js"></script>
        <script type="text/javascript" src="/test/handlers.js"></script>
        
        <script type="text/javascript">
              
            
            
            
            $(document).ready(function(){
                
                $("#web-form1").validate({
                    errorLabelContainer: $("#web-form1 div.error")
                    
                });
                
                questionJsObject.attachEvents();
                
                //attach fancybox
               $(".fancybox").fancybox({
                    'width'				: '75%',
                    'height'			: '75%',
                    'autoScale'     	: false,
                    'transitionIn'		: 'none',
                    'transitionOut'		: 'none',
                    'type'				: 'inline'
                });
            });
       
              
              
            var swfu;
            
            window.onload = function() {
                var settings = {
                    flash_url : "/swfupload/swfupload.swf",
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
       
       <style type="text/css">
              .hide-me {
                     display:none ;
              }
              div#link-data {
              
              }
              
              div#media-data {
              
              }
              
              div#link-container {
                     width:600px;
                     /* margin-top :20px;
                     margin-bottom :20px; */
                     padding:20px;
                     /* border: 1px dotted blue; */
                     
              }
              
              div#link-container input{
                     word-spacing: 1px;
                     line-height: 1.8em;
                     color: #333;
                     border: 1px solid #bbb;
                     width: 400px;
                     height: 24px;
                     padding-top:4px;
              }
              
              div#link-container button {
                     background-color:black;
                     color:#FFFFFF !important;
                     text-align :center ;
                     border-radius:5px;
                     text-decoration:none
                     font-weight: bold;
                     cursor: pointer;
              }
              
              div#image-container{
                     margin-bottom:20px;
                     margin-left:40px;
                     padding:20px;
                     border:1px dashed #DDD ;
              }

              #form-wrapper #divstatus{
                     padding:5px;
              }
              
              #media-data {
                     width: 580px;
              }
              .previewImage{
                     position :relative ;
                     float : left;
                     padding:11px;
                     height:180px;
                     width:180px;
                     border:2px solid #DDD ;
                     margin :5px;
              }
              
       </style>
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
                                       Please provide details below to register. Use alphanumeric password of atleast 8 characters.

                                    </p>
                                    
                                    <?php FormMessage::render(); ?>
                            
                                    <div id="form-wrapper">
                                        <form id="web-form1"  name="web-form1" action="/user/form/register.php" enctype="multipart/form-data"  method="POST">

                                            <div class="error">    </div>

                                            <table class="form-table">

                                                 <tr>
                                                    <td class="field"> Question <span class="red-label">*</span></td>
                                                    <td>
                                                        <input type="text" name="question" maxlength="128" class="required" title="&gt; Queston is required"! value="<?php echo $sticky->get('question'); ?>"/>
                                                    </td>
                                                 </tr>
                                                 
                                                 <tr>
                                                        <td class="field"> Details</td>
                                                        <td>
                                                            <textarea  name="description" class="h130" cols="50" rows="4" ><?php echo $sticky->get('description'); ?></textarea>
                                                        </td>
                                                 </tr>
                                                 <tr>
                                                    <td class="field">Location<span class="red-label">*</span> &nbsp; </td>
                                                    <td> <input type="text" name="location" maxlength="32" class="w200 required" minlength="3" title="&gt; Location is required!" value="" /></td>
                                                </tr>

                                                <tr>
                                                    <td class="field">Tags <span class="red-label">*</span> &nbsp;</td>
                                                    <td> <input  type="text" name="tags" maxlength="64" class="required"  title="&gt; Tags are required!" value="" /></td>
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
                                            <p> Use a url shortening service like goo.gl to shorten long url</p>
                                            Link*&nbsp;<input  id="link-box"  type="text" name="link" maxlength="64" value="" />
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
                                            
                                        </form>
                                    </div> <!-- form wrapper -->
                                   
                                   
                            </div> <!-- content -->


                        </div> <!-- u-2-3 -->
                        
                         <div class="yui3-u-1-3">
                            <!-- sidebar -->
                        </div> <!-- u-1-3 -->
                        
                    </div> <!-- GRID -->


                </div> <!-- bd -->


              <div id="js-debug">
              </div>
              
        </div> <!-- body wrapper -->
        <div id="ft">
            <?php include($_SERVER['APP_WEB_DIR'] . '/inc/site-footer.inc'); ?>
        </div>

    </body>
</html>
