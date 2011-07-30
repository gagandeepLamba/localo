<?php
include ('job-app.inc');
include ($_SERVER['APP_WEB_DIR'].'/inc/header.inc');
use webgloo\job\Constants ;
use webgloo\common\ui\form as Form;
$sticky = new Form\Sticky($gWeb->find(Constants::STICKY_MAP, true));

?>  

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>

       <head><title> User registration page</title>
         

        <meta http-equiv="content-type" content="text/html; charset=ISO-8859-1" />

        <link rel="stylesheet" type="text/css" href="http://yui.yahooapis.com/3.3.0/build/cssgrids/grids-min.css">
        <!-- app css here -->
        <link rel="stylesheet" type="text/css" href="/css/main.css">
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
        
        <div id="body-wrapper">

                <div id="hd">
                     <?php include($_SERVER['APP_WEB_DIR'] . '/inc/banner.inc'); ?>
                </div>
                <div id="bd">

                    <div class="yui3-g">
                        <div class="yui3-u-5-24">
                            
                        </div> <!-- left unit -->
                        <div class="yui3-u-19-24">
                            <div id="main-panel">

                                    <h2> User Registration </h2>


                                    <p class="help-text">
                                       Please provide details below to continue

                                    </p>
                                     <?php include($_SERVER['APP_WEB_DIR'] . '/inc/form/message.inc'); ?>

                                    <div id="form-wrapper">
                                        <form id="web-form1" class="web-form" name="web-form1" action="/user/post/register.php" enctype="multipart/form-data"  method="POST">

                                            <div class="error">    </div>

                                            <table class="form-table">

                                                 <tr>
                                                    <td class="field"> First Name<span class="red-label">*</span></td>
                                                    <td>
                                                        <input type="text" name="first_name" maxlength="100" class="required" title="&gt;&nbsp;First name is a required field" value="<?php echo $sticky->get('first_name'); ?>"/>
                                                    </td>
                                                 </tr>
                                                 <tr>
                                                    <td class="field"> Last Name<span class="red-label">*</span></td>
                                                    <td>
                                                        <input type="text" name="last_name" maxlength="100" class="required" title="&gt;&nbsp;Last name is a required field" value="<?php echo $sticky->get('last_name'); ?>"/>
                                                    </td>
                                                 </tr>
                                                <tr>
                                                    <td class="field"> Phone</td>
                                                    <td>
                                                        <input type="text" name="phone" maxlength="16" value="<?php echo $sticky->get('phone'); ?>"/>
                                                    </td>
                                                 </tr>
                                                  <tr>
                                                    <td class="field"> Company</td>
                                                    <td>
                                                        <input type="text" name="company" maxlength="64" value="<?php echo $sticky->get('compnay'); ?>"/>
                                                    </td>
                                                 </tr>
                                                  <tr>
                                                    <td class="field"> Job title</td>
                                                    <td>
                                                        <input type="text" name="title" maxlength="64" value="<?php echo $sticky->get('title'); ?>"/>
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
                                                    <td class="field">Retype Password <span class="red-label">*</span> &nbsp;</td>
                                                    <td> <input id="password_again" type="password" name="password_again" maxlength="32" class="required" minlength="8"  title="passwords do not match" value="" /></td>
                                                </tr> 
                                                

                                            </table>

                                            


                                            <div class="button-container">

                                                <div class="submit">
                                                    <div>
                                                        <button type="submit" name="register" value="Register" onclick="this.setAttribute('value','Register');" ><span>Register</span></button>
                                                    </div>
                                                </div>

                                                <div class="button">
                                                    <div>
                                                        <button type="button" name="cancel" onClick="javascript:go_back('http://www.test2.com');"><span>Cancel</span></button>
                                                    </div>
                                                </div>

                                            </div>
                                            
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
