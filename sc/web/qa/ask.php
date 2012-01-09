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


        <script type="text/javascript">
            $(document).ready(function(){
                //form validator
                //http://docs.jquery.com/Plugins/Validation/Methods/equalTo
                //new jquery validate plugin can accept rules
                
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
                                                    <td class="field">Link</td>
                                                    <td> <input  type="text" name="link" maxlength="128" value="" /></td>
                                                </tr>
                                                  
                                                 <tr>
                                                        <td class="field"> Details</td>
                                                        <td>
                                                            <textarea  name="description" class="h130" cols="50" rows="4" ><?php echo $sticky->get('description'); ?></textarea>
                                                        </td>
                                                 </tr>
                                                 <tr>
                                                    <td class="field">Location<span class="red-label">*</span> &nbsp; </td>
                                                    <td> <input type="text" name="location" maxlength="32" class="required" minlength="3" title="&gt; Location is required!" value="" /></td>
                                                </tr>

                                                <tr>
                                                    <td class="field">Tags <span class="red-label">*</span> &nbsp;</td>
                                                    <td> <input  type="text" name="tags" maxlength="64" class="required"  title="&gt; Tags are required!" value="" /></td>
                                                </tr>

                                                
                                            </table>

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



        </div> <!-- body wrapper -->
        <div id="ft">
            <?php include($_SERVER['APP_WEB_DIR'] . '/inc/site-footer.inc'); ?>
        </div>

    </body>
</html>
