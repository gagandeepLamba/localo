<?php
    //link/add.php
    include ('news-app.inc');
    include($_SERVER['APP_WEB_DIR'] . '/inc/header.inc');
    //@see http://www.google.com/recaptcha
    include($_SERVER['WEBGLOO_LIB_ROOT'] . '/ext/recaptchalib.php');
    
    use com\indigloo\Util;
    use com\indigloo\ui\form\Sticky;
    use com\indigloo\Constants as Constants;
    use com\indigloo\ui\form\Message as FormMessage;
     
    $sticky = new Sticky($gWeb->find(Constants::STICKY_MAP,true));
    
?>



<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>

    <head><title> Submit your story</title>

        <meta http-equiv="content-type" content="text/html; charset=ISO-8859-1" />

        <link rel="stylesheet" type="text/css" href="/3p/yui3/grids-min.css">
        <link rel="stylesheet" type="text/css" href="/css/news.css">
        
        <script type="text/javascript" src="/3p/jquery/jquery-1.6.4.min.js"></script>
        <script type="text/javascript" src="/3p/jquery/jquery.validate.1.9.0.min.js"></script>

      
        <script type="text/javascript">
            $(document).ready(function(){
                //form validator
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
                            <h2> Submit your story </h2>


                            <p class="help-text">
                                Read something interesting? Please share it with us.

                            </p>

                            <?php FormMessage::render(); ?>
                            
                            <div id="form-wrapper">
                                <form id="web-form1" class="web-form" name="web-form1" action="/link/form/add.php" enctype="multipart/form-data"  method="POST">

                                    <div class="error">    </div>

                                    <table class="form-table">
                                        <tr>
                                            <td class="field"> Link<span class="color-red">*</span></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <input type="text" name="link" class="required w580" title="&nbsp;Link is required" value="<?php echo $sticky->get('link'); ?>"/>
                                            </td>
                                        </tr>
                                        
                                        <tr>
                                            <td class="field"> Your name or email<span class="color-red">*</span></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <input type="text" name="author" maxlength="64" class="required w580" title="&nbsp;Your name or email is required" value="<?php echo $sticky->get('author','Anonymous'); ?>"/>
                                            </td>
                                        </tr>
                                        
                                        <tr>
                                           <td>  <span> Description </span> </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <textarea name="description" class="h130 w580" cols="50" rows="4" ><?php echo $sticky->get('description'); ?></textarea> </td>
                                            </td>
                                        </tr>
                                     
                                    </table>
                                    <div class="ml20">
                                        <?php
                                            $publickey = "6Ld7Xs0SAAAAAI_v62wXq28C_XeE5FQCBYMFG6vU"; 
                                            echo recaptcha_get_html($publickey);
                                       ?>
                                           
                                    </div>
                                    
                                    <div class="p20">
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
                                     
                                    <div style="clear: both;"></div>

                                </form>
                            </div> <!-- form wrapper -->


                        </div> <!-- content -->

                    </div>
                    
                    <div class="yui3-u-1-3">
                        <?php include($_SERVER['APP_WEB_DIR'] . '/inc/sidebar/link-add.inc'); ?>
                    </div>
                    
                    
                </div> <!-- GRID -->


            </div> <!-- bd -->



        </div> <!-- body wrapper -->

        <div id="ft">
            <?php include($_SERVER['APP_WEB_DIR'] . '/inc/site-footer.inc'); ?>
        </div>

    </body>
</html>
