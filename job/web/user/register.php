<?php
    include ('job-app.inc');
    include ($_SERVER['APP_WEB_DIR'].'/inc/header.inc');
    use webgloo\job\Constants ;
    use webgloo\common\ui\form as Form;
    $sticky = new Form\Sticky($gWeb->find(Constants::STICKY_MAP, true));
    $previousUrl = $gWeb->getPreviousUrl();
    
?>  

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>

       <head><title> User registration page</title>
         

        <meta http-equiv="content-type" content="text/html; charset=ISO-8859-1" />

        <link rel="stylesheet" type="text/css" href="/css/grids-min.css">
        <link rel="stylesheet" type="text/css" href="/css/style.css">
        <!-- include any javascript here -->
        <script type="text/javascript" src="/js/jquery-1.6.2.min.js"></script>
        <script type="text/javascript" src="/js/jquery.validate.min.js"></script>

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
                     <!-- no banner -->
                </div>
                <div id="bd">

                    <div class="yui3-g">
                        <div class="yui3-u-1-3">
                            <?php include($_SERVER['APP_WEB_DIR'] . '/inc/left-panel.inc'); ?>
                        </div> <!-- left unit -->
                
                        <div class="yui3-u-2-3">
                            <div id="content">

                                    <h2> User Registration </h2>


                                    <p class="help-text">
                                       Please provide details below to register.

                                    </p>
                                     <?php include($_SERVER['APP_WEB_DIR'] . '/inc/form/message.inc'); ?>

                                    <div id="form-wrapper">
                                        <form id="web-form1"  name="web-form1" action="/user/post/register.php" enctype="multipart/form-data"  method="POST">

                                            <div class="error">    </div>

                                            <table class="form-table">

                                                 <tr>
                                                    <td class="field"> Name<span class="red-label">*</span></td>
                                                    <td>
                                                        <input type="text" name="name" maxlength="64" class="required" title="&gt;&nbsp;Name is a required field" value="<?php echo $sticky->get('name'); ?>"/>
                                                    </td>
                                                 </tr>

                                                  <tr>
                                                    <td class="field"> Email<span class="red-label">*</span></td>
                                                    <td>
                                                        <input type="text" id="email" name="email" maxlength="64" class="required mail" title="&gt;&nbsp;wrong email" value="<?php echo $sticky->get('email'); ?>"/>
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
                                                 <a href="<?php echo $previousUrl; ?>">
                                                    <button class="form-button" type="button" name="cancel"><span>Cancel</span></button>
                                                </a>
                                                
                                            </div>
                                            
                                            <div style="clear: both;"></div>

                                        </form>
                                    </div> <!-- form wrapper -->

                            </div>


                        </div> <!-- content -->
                    </div> <!-- GRID -->


                </div> <!-- bd -->



        </div> <!-- body wrapper -->

        <?php include($_SERVER['APP_WEB_DIR'] . '/inc/site-footer.inc'); ?>


    </body>
</html>
