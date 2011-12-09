<?php

    //user/register.php
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

       <head><title> User registration page</title>
         

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
                    errorLabelContainer: $("#web-form1 div.error"),
                    rules: {
                        password: "required",
                        password_again: {
                            equalTo: "#password"
                        },
                        email : {
                            required: true ,
                            email : true
                        }
                     }
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

                                    <h2> User Registration </h2>


                                    <p class="help-text">
                                       Please provide details below to register. Use alphanumeric password of atleast 8 characters.

                                    </p>
                                    
                                    <?php FormMessage::render(); ?>
                            
                                    <div id="form-wrapper">
                                        <form id="web-form1"  name="web-form1" action="/user/form/register.php" enctype="multipart/form-data"  method="POST">

                                            <div class="error">    </div>

                                            <table class="form-table">

                                                 <tr>
                                                    <td class="field"> Name<span class="red-label">*</span></td>
                                                    <td>
                                                        <input type="text" name="name" maxlength="32" class="required" title="&nbsp;Name is required" value="<?php echo $sticky->get('name'); ?>"/>
                                                    </td>
                                                 </tr>

                                                  <tr>
                                                    <td class="field"> Email<span class="red-label">*</span></td>
                                                    <td>
                                                        <input type="text" id="email" name="email" maxlength="64" class="required mail" title="&nbsp;wrong email" value="<?php echo $sticky->get('email'); ?>"/>
                                                    </td>
                                                </tr>
                                                 <tr>
                                                    <td class="field">Password<span class="red-label">*</span> &nbsp; </td>
                                                    <td> <input id="password" type="password" name="password" maxlength="32" class="required" minlength="8" title="password should be atleast 8 chars!" value="" /></td>
                                                </tr>

                                                <tr>
                                                    <td class="field">Confirm Password <span class="red-label">*</span> &nbsp;</td>
                                                    <td> <input id="password_again" type="password" name="password_again" maxlength="32" class="required" minlength="8"  title="passwords do not match" value="" /></td>
                                                </tr>

                                                
                                            </table>

                                            <div class="button-container">
                                                <button class="form-button" type="submit" name="register" value="Register" onclick="this.setAttribute('value','Register');" ><span>Register</span></button>
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
                            <?php include($_SERVER['APP_WEB_DIR'] . '/inc/sidebar.inc'); ?>
                        </div> <!-- u-1-3 -->
                        
                    </div> <!-- GRID -->


                </div> <!-- bd -->



        </div> <!-- body wrapper -->
        <div id="ft">
            <?php include($_SERVER['APP_WEB_DIR'] . '/inc/site-footer.inc'); ?>
        </div>

    </body>
</html>
