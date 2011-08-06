<?php
include 'job-app.inc';
//set the global variables
include($_SERVER['APP_WEB_DIR'] . '/inc/header.inc');
include($_SERVER['APP_WEB_DIR'] . '/inc/user/role.inc');


use webgloo\common\Util ;
use webgloo\common\ui\form\Sticky ;
use webgloo\job\Constants ;
use webgloo\auth\FormAuthentication ;

//attching media for this application.
$applicationId = $gWeb->getRequestParam('g_application_id');
Util::isEmpty('applicatonId', $applicationId);

$applicationDao = new webgloo\job\dao\Application();
$applicationDBRow = $applicationDao->getRecordOnId($applicationId);
$applicationHtml = webgloo\job\html\template\Application::getUserSummary($applicationDBRow,array());

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

    <head><title> Edit documents for an application </title>

        <meta http-equiv="content-type" content="text/html; charset=ISO-8859-1" />

        <!-- swfupload related stuff -->
        <link href="/swfupload/default.css" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" type="text/css" href="/css/grids-min.css">
        <link rel="stylesheet" type="text/css" href="/css/jquery/flick/jquery-ui-1.8.14.custom.css">
        <link rel="stylesheet" type="text/css" href="/css/main.css">

        <!-- app css here -->
        <!-- include any javascript here -->
        <script type="text/javascript" src="/js/jquery-1.6.2.min.js"></script>
        <script type="text/javascript" src="/js/jquery-ui-1.8.14.custom.min.js"></script>
        <script type="text/javascript" src="/js/json2.js"></script>
        <!-- main.js uses jquery and json -->
        <script type="text/javascript" src="/js/main.js"></script>

        
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

                 //create dialog box
                $("#gui-dialog").dialog({
                    autoOpen: false,
                    modal: true,
                    draggable: true,
                    position: 'center',
                    width: '310px'}) ;

            });
            
            //swffileupload related javascript
            var swfu;

            window.onload = function() {
                var settings = {
                    flash_url : "/swfupload/swfupload.swf",
                    upload_url: "/swfupload/receiver.php",
                    post_params: {
                        "PHPSESSID" : "<?php echo session_id(); ?>",
                        "entity_id" : "<?php echo $applicationId;  ?>",
                        "entity_name" : "APPLICATION"
                    },
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
                            <h2> Edit documents for application </h2>
                            <br>
                            
                            <div class="help">
                                You can add or remove documents for your application here. You can also do that later.
                                <a href="/"> Fine, I will attach the documents later.</a>
                            </div>
                            <div>
                                <!-- include application summary  -->
                                <?php echo $applicationHtml; ?>

                            </div>
                            

                            <h2> Documents  </h2>
                            
                            <?php include($_SERVER['APP_WEB_DIR'] . '/inc/form/message.inc'); ?>

                            <div id="preview">
                                &nbsp; <br>
                                
                                <table class="form-table">


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
                                    <div>
                                        <span id="spanButtonPlaceHolder"></span>
                                        <input id="btnCancel" type="button" value="Cancel All Uploads" onclick="swfu.cancelQueue();" disabled="disabled" style="margin-left: 2px; font-size: 8pt; height: 29px;" />
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

        <div id="ft">
            <?php include($_SERVER['APP_WEB_DIR'] . '/inc/site-footer.inc'); ?>
        </div>

        <!-- code for common UI dialog box -->
        <div id="gui-dialog" title="">
            <div id="gui-dialog-results"> </div>
        </div>
        
    </body>
</html>
