<?php
    //post/add.php
    include ('news-app.inc');
    include($_SERVER['APP_WEB_DIR'] . '/inc/header.inc');
    
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

        <link rel="stylesheet" type="text/css" href="/lib/yui3/grids-min.css">
        <link rel="stylesheet" type="text/css" href="/css/style.css">
        
        <script type="text/javascript" src="/lib/jquery/jquery-1.6.4.min.js"></script>
        <script type="text/javascript" src="/lib/jquery/jquery.validate.1.9.0.min.js"></script>

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
                            <h2> Add new post </h2>


                            <p class="help-text">
                                Please fill in the details below and create your post.

                            </p>

                            <?php FormMessage::render(); ?>
                            
                            <div id="form-wrapper">
                                <form id="web-form1" class="web-form" name="web-form1" action="/link/form/add.php" enctype="multipart/form-data"  method="POST">

                                    <div class="error">    </div>

                                    <table class="form-table">

                                        <tr>
                                            <td class="field"> Title<span class="red-label">*</span></td>
                                            <td>
                                                <input type="text" name="title" maxlength="128" class="required w580" title="&nbsp;Title is required" value="<?php echo $sticky->get('title'); ?>"/>
                                            </td>
                                        </tr>
                                        
                                        <tr>
                                            <td> &nbsp; </td>
                                            <td>  <span> Summary </span> <br> <textarea  name="summary" class="required h130 w580" title="&nbsp;Summary is required" cols="50" rows="4" ><?php echo $sticky->get('summary'); ?></textarea> </td>
                                        </tr>
                                        
                                        <tr>
                                            <td class="field"> Link<span class="red-label">*</span></td>
                                            <td>
                                                <input type="text" name="link" maxlength="128" class="required w580" title="&nbsp;Link is required" value="<?php echo $sticky->get('link'); ?>"/>
                                            </td>
                                        </tr>
                                        
                                        

                                    </table>

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



        </div> <!-- body wrapper -->

        <div id="ft">
            <?php include($_SERVER['APP_WEB_DIR'] . '/inc/site-footer.inc'); ?>
        </div>

    </body>
</html>
