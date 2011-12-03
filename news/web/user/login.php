<?php
    include ('news-app.inc');
    include ($_SERVER['APP_WEB_DIR'].'/inc/header.inc');
    
    use com\indigloo\Util;
    use com\indigloo\ui\form\Sticky;
    use com\indigloo\Constants as Constants;
    use com\indigloo\ui\form\Message as FormMessage;
     
    $sticky = new Sticky($gWeb->find(Constants::STICKY_MAP,true));
    $fwdURI = empty($_GET['q']) ? '' : $_GET['q'] ;
    
?>  

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>

       <head><title> login page</title>
         

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
                        <div class="yui3-u-1-3">
                            
                        </div>
                        <div class="yui3-u-2-3">
                            <div id="content">

                                    <h3> Login</h3>


                                    <p class="help-text">
                                    
                                    </p>
                                    
                                     <?php FormMessage::render(); ?>

                                    <div id="form-wrapper">
                                        <form id="web-form1"  name="web-form1" action="/user/form/login.php" enctype="multipart/form-data"  method="POST">

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
                                                <a href="<?php echo $fwdURI; ?>">
                                                    <button class="form-button" type="button" name="cancel"><span>Cancel</span></button>
                                                </a>
                                                
                                            </div>

                                            <div style="clear: both;"></div>
                                            <input type="hidden" name="fwd_uri" value="<?php echo $fwdURI; ?>" />
                                            
                                        </form>
                                    </div> <!-- form wrapper -->

                                    <div>
                                        No account? <a href="/user/register.php"> Register</a>
                                        &nbsp;|&nbsp;forgot password? mail <a href="mailto:support@27main.com">support@27main.com</a>
                                    </div>

                            </div>
                            


                        </div> <!-- content -->
                    </div> <!-- GRID -->


                </div> <!-- bd -->

        </div> <!-- body wrapper -->
        
        <?php include($_SERVER['APP_WEB_DIR'] . '/inc/site-footer.inc'); ?>

    </body>
</html>
