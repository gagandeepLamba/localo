<?php
    //post/add.php
    include ('news-app.inc');
    include($_SERVER['APP_WEB_DIR'] . '/inc/header.inc');
    include($_SERVER['APP_WEB_DIR'] . '/inc/role/staff.inc');
    
    use com\indigloo\Util;
    use com\indigloo\ui\form\Sticky;
    use com\indigloo\Constants as Constants;
    use com\indigloo\ui\form\Message as FormMessage;
    
    $sticky = new Sticky($gWeb->find(Constants::STICKY_MAP,true));
    
   

?>



<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>

    <head><title> Post a news item</title>

        <meta http-equiv="content-type" content="text/html; charset=ISO-8859-1" />

        <link rel="stylesheet" type="text/css" href="/3p/yui3/grids-min.css">
        <link rel="stylesheet" type="text/css" href="/css/news.css">
        
        <script type="text/javascript" src="/3p/jquery/jquery-1.6.4.min.js"></script>
        <script type="text/javascript" src="/3p/jquery/jquery.validate.1.9.0.min.js"></script>
        <script type="text/javascript" src="/js/news.js"></script>
        
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
                
                webgloo.news.post.attachEvents();
            });
            
            var swfu;
            
            window.onload = function() {
                var settings = {
                    flash_url : "/3p/swfupload/swfupload.swf",
                    upload_url: "/post/receiver.php",
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
                    upload_success_handler : webgloo.news.post.uploadSuccess,
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
                            <h2> Add new post </h2>


                            <p class="help-text">
                                Please fill in the details below and create your post.

                            </p>

                            <?php FormMessage::render(); ?>
                            
                            <div id="form-wrapper">
                                <form id="web-form1" class="web-form" name="web-form1" action="/post/form/add.php" enctype="multipart/form-data"  method="POST">

                                    <div class="error">    </div>

                                    <table class="form-table">

                                        <tr>
                                            <td class="field"> </td>
                                            <td>
                                                Title<span class="red-label">*</span> (Alphanumeric only)
                                                <br/>
                                                <input type="text" name="title" maxlength="128" class="required w580" title="&nbsp;Title is required" value="<?php echo $sticky->get('title'); ?>"/>
                                            </td>
                                        </tr>
                                        
                                        <tr>
                                            <td> &nbsp; </td>
                                            <td>  <span> Summary </span> <br> <textarea  name="summary" class="required h130 w580" title="&nbsp;Summary is required" cols="50" rows="4" ><?php echo $sticky->get('summary'); ?></textarea> </td>
                                        </tr>
                                        <tr>
                                            <td> &nbsp; </td>
                                            <td>
                                                
                                                
                                                <span>
                                                    Description
                                                    (Use <a href="http://www.w3.org/TR/xhtml1/" target="_blank">xhtml</a> tags for formatting)
                                                    
                                                </span>
                                                <br/>
                                                <br />
                                                <textarea name="description" class="w580" cols="50" rows="10" ><?php echo $sticky->get('description'); ?></textarea> </td>
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
                                   
                                    
                                    <div class="tc">
                                        By posting information here you agree to the <a href="/help/tc.php" target="_blank"> Terms and Conditions </a>
                                        imposed by this website. Please read them carefully.
                                    </div>
            

                                    <div class="button-container">
                                        <button class="form-button" type="submit" name="save" value="Save" onclick="this.setAttribute('value','Save');" ><span>Save</span></button>
                                        <a href="#">
                                            <button class="form-button"  type="button" name="cancel"><span>Cancel</span></button>
                                        </a>
                                    </div>


                                    <!-- hidden fields -->
                                    <input type="hidden" name="organization_id" value="1234" />
                                    <input type="hidden" name="links_json" value="" />
                                    <input type="hidden" name="images_json" value="" />
                                            
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
            
            <div id="js-debug"> </div>


        </div> <!-- body wrapper -->

        <div id="ft">
            <?php include($_SERVER['APP_WEB_DIR'] . '/inc/site-footer.inc'); ?>
        </div>
        
        
    </body>
</html>
