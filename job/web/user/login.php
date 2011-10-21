<?php
    include ('job-app.inc');
    include ($_SERVER['APP_WEB_DIR'].'/inc/header.inc');
    use com\mik3\Constants ;
    use com\indigloo\common\ui\form as Form;
    $sticky = new Form\Sticky($gWeb->find(Constants::STICKY_MAP, true));

    $previousUrl = $gWeb->getPreviousUrl();
?>  

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>

       <head><title> User logon</title>
         

        <meta http-equiv="content-type" content="text/html; charset=ISO-8859-1" />
        <link rel="stylesheet" type="text/css" href="/css/grids-min.css">
        <link rel="stylesheet" type="text/css" href="/css/style.css">
        <script type="text/javascript" src="/js/jquery-1.6.2.min.js"></script>
        <script type="text/javascript" src="/js/jquery.validate.min.js"></script>

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
                        <div class="yui3-u-1-3">
                            
                        </div>
                        <div class="yui3-u-2-3">
                            <div id="content">

                                    <h3> Sign In</h3>


                                    <p class="help-text">
                                    
                                    </p>
                                     <?php include($_SERVER['APP_WEB_DIR'] . '/inc/form/message.inc'); ?>

                                    <div id="form-wrapper">
                                        <form id="web-form1"  name="web-form1" action="/user/post/login.php" enctype="multipart/form-data"  method="POST">

                                            <div class="error">    </div>

                                            <table class="form-table">
                                                <tr>
                                                    <td class="field"> Email<span class="red-label">*</span></td>
                                                    <td>
                                                        <input type="text" name="email" maxlength="100" class="required" title="&gt;&nbsp;Email is a required field" value="<?php echo $sticky->get('email'); ?>"/>
                                                    </td>
                                                </tr>

                                                 <tr>
                                                    <td class="field"> Password<span class="red-label">*</span></td>
                                                    <td>
                                                        <input type="password" name="password" maxlength="100" class="required" title="&gt;&nbsp;Password is a required field" value=""/>
                                                    </td>
                                                </tr>
                                             
                                            </table>

                                            <div class="button-container">
                                                <button class="form-button" type="submit" name="login" value="Login" onclick="this.setAttribute('value','Login');" ><span>Login</span></button>
                                                <a href="<?php echo $previousUrl; ?>">
                                                    <button class="form-button" type="button" name="cancel"><span>Cancel</span></button>
                                                </a>
                                                
                                            </div>

                                            <div style="clear: both;"></div>

                                        </form>
                                    </div> <!-- form wrapper -->

                                    <div>
                                        No account? <a href="/user/register.php"> Register</a>
                                        &nbsp;|&nbsp;forgot password? mail <a href="mailto:support@mik3.com">support@mik3.com</a>
                                    </div> <!-- action links -->

                            </div>
                            


                        </div> <!-- content -->
                    </div> <!-- GRID -->


                </div> <!-- bd -->

        </div> <!-- body wrapper -->
        
        <?php include($_SERVER['APP_WEB_DIR'] . '/inc/site-footer.inc'); ?>

    </body>
</html>
