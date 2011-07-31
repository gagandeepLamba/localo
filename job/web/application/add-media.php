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
$applicatonId = $gWeb->getRequestParam('g_application_id');
//@todo remove hardcoded
$applicatonId = 2 ;
Util::isEmpty('applicatonId', $applicatonId);

$applicationDao = new webgloo\job\dao\Application();
$applicationDBRow = $applicationDao->getRecordOnId($applicatonId);
$applicationHtml = webgloo\job\html\template\Application::getUserSummary($applicationDBRow);

//find and destroy sticky map
$sticky = new Sticky($gWeb->find(Constants::STICKY_MAP,true));
//This method will throw an error
$userVO = FormAuthentication::getLoggedInUser();


?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>

    <head><title> Add documents for application </title>

        <meta http-equiv="content-type" content="text/html; charset=ISO-8859-1" />

        <link rel="stylesheet" type="text/css" href="/css/grids-min.css">
        <link rel="stylesheet" type="text/css" href="/css/main.css">

        <!-- app css here -->
        <!-- include any javascript here -->
        <script type="text/javascript" src="/js/jquery-1.6.2.min.js"></script>
        <script type="text/javascript" src="/js/jquery.validate.min.js"></script>
        <script type="text/javascript" src="/js/json2.js"></script>
        <script type="text/javascript" src="/js/main.js"></script>

        <script type="text/javascript">

            //original source of supplant method
            //http://javascript.crockford.com/remedial.html

            String.prototype.supplant = function (o) {
                return this.replace(/{([^{}]*)}/g,
                    function (a, b) {
                        var r = o[b];
                        return typeof r === 'string' || typeof r === 'number' ? r : a;
                });
            };
            //Add document handler functionality
            var webgloo = {}
            webgloo.gMedia = { 
                debug :false ,
                documentId : []
            
            }
            
            webgloo.gMedia.table = {
                removeRow : function(documentId){
                    //remove this row
                    tableRowId = "div#preview table tr#" + documentId ;
                    $(tableRowId).remove();
                    //update document_id json in form
                    
                },
                addRow : function(documentId,documentName) {
                    if(webgloo.gMedia.debug) { alert( "doc name => " + documentName); }
                    
                    params = {id: documentId ,name: documentName};
                    buffer = this.rowHtml.supplant(params);
                    //Add this html to table in preview DIV
                    $("div#preview table").append(buffer);

                    frm = document.forms["web-form1"];
                    var documentIdOnForm = frm.document_id.value ;
                    var docIdObj = JSON.parse(documentIdOnForm);
                    
                    //Add the documentId to document_id form element
                    
                    //push json data into hidden form variable
                    frm = document.forms["web-form1"];
                    frm.document_id.value = data ;
                    
                },
                rowHtml : '<tr class="item" id="{id}"> <td> {name} </td>  <td> &nbsp;<a href="#" id="{id}" class="removeMedia"> Delete </a> </td> </tr>'
                   
            }
            //attach events
            $(document).ready(function(){
                $("a.removeMedia").live("click", function(event){
                    event.preventDefault();
                    var docId = $(this).attr("id");
                    //remove flexi data
                    webgloo.gMedia.table.removeRow(docId);
                }) ;

            });


        </script>
        <!-- swfupload related stuff -->
        <link href="/swfupload/default.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="/swfupload/swfupload.js"></script>
        <script type="text/javascript" src="/swfupload/js/swfupload.queue.js"></script>
        <script type="text/javascript" src="/swfupload/js/fileprogress.js"></script>
        <script type="text/javascript" src="/swfupload/js/handlers.js"></script>

        <script type="text/javascript">

            
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
                                <form id="web-form1" class="web-form" name="web-form1" action="/application/post/add-media.php" enctype="multipart/form-data"  method="POST">

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
                                    <input type="hidden" name="application_id" value="<?php echo $applicationId; ?>" />
                                    <input type="hidden" name="document_id" value="" />
                                    
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