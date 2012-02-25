<?php
    include ('sc-app.inc');
    include ($_SERVER['APP_WEB_DIR'].'/inc/header.inc');
    
    use com\indigloo\Util;
    use com\indigloo\ui\form\Sticky;
    use com\indigloo\Constants as Constants;
    use com\indigloo\ui\form\Message as FormMessage;
     
    $sticky = new Sticky($gWeb->find(Constants::STICKY_MAP,true));
    $fwdURI = empty($_GET['q']) ? '' : $_GET['q'] ;
    $_SESSION["state"] = "rajeev" ;
    
    $fbDialogUrl = "https://www.facebook.com/dialog/oauth?client_id=" ;
    $fbDialogUrl .= "282966715106633&redirect_uri=" ;
    $fbDialogUrl .= "http://www.3mik.com/callback/fb2.php&scope=email";
    $fbDialogUrl .= "&state=".$_SESSION['state']
    
?>  

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>

       <head><title> 3mik.com - login page</title>
         

        <meta http-equiv="content-type" content="text/html; charset=ISO-8859-1" />
        
        <link rel="stylesheet" type="text/css" href="/3p/bootstrap/css/bootstrap.css">
        <link rel="stylesheet" type="text/css" href="/css/sc.css">
		<script type="text/javascript" src="/3p/jquery/jquery-1.7.1.min.js"></script>
		<script type="text/javascript" src="/3p/bootstrap/js/bootstrap.js"></script>
		
        <script type="text/javascript" src="/3p/jquery/jquery.validate.1.9.0.min.js"></script>


        <script type="text/javascript">
            $(document).ready(function(){
                
                $("#web-form1").validate({
                    errorLabelContainer: $("#web-form1 div.error")
                });
                
            });
            
        </script>
					
							  
    </head>

     <body>
        
		<div class="container">
			<div class="row">
				<div class="span12">
					<?php include($_SERVER['APP_WEB_DIR'] . '/inc/toolbar.inc'); ?>
				</div> 
				
			</div>
			
			<div class="row">
				<div class="span12">
					<?php include($_SERVER['APP_WEB_DIR'] . '/inc/banner.inc'); ?>
				</div>
			</div>
			
			
			<div class="row">
				<div class="span8">
                    <div class="page-header">
                        <h2> Login Page </h2>
                    </div>
                                                    
                    <?php FormMessage::render(); ?>
                    <div class="wrapper">
                        <div class="twitter-login">
                           <div> <a href="<?php echo $fbDialogUrl; ?>"> Login with Facebook</a></div>
                        </div>
                        <div class="twitter-login">
                            <div>
                                <a href="/user/twitter-login.php"> Login with Twitter</a>
                            </div>
                        </div>
                        <img src="/nuke/twitter-bird.png" width="30" height="30"/>
                    </div> <!-- wrapper -->
                    <div class="mt20 alert alert-info">
                        You can login with a facebook or twitter account on this site.
                        However for better site experience we suggest you create a 3mik.com account
                    </div>
                    
                    <div class="page-header">
                        <h2> Login with 3mik.com account </h2>
                         No 3mik.com account? <a href="/user/register.php"> Register for a new account</a> (Free and takes just 30 seconds!)
                    </div>
                      
                    <form id="web-form1"  name="web-form1" action="/user/form/login.php" enctype="multipart/form-data"  method="POST">

                        <div class="error">    </div>

                        <table class="form-table">
                            <tr>
                                <td class="field"> Email<span class="red-label">*</span></td>
                                <td>
                                    <input type="text" name="email" maxlength="64" class="required" title="Email is required" value="<?php echo $sticky->get('email'); ?>"/>
                                </td>
                            </tr>

                             <tr>
                                <td class="field"> Password<span class="red-label">*</span></td>
                                <td>
                                    <input type="password" name="password" maxlength="32" class="required" title="Password is required" value=""/>
                                </td>
                            </tr>
                         
                        </table>

                        <div class="form-actions">
                            <button class="btn btn-primary" type="submit" name="login" value="Login" onclick="this.setAttribute('value','Login');" ><span>Login</span></button>
                            <a href="<?php echo $fwdURI; ?>">
                                <button class="btn" type="button" name="cancel"><span>Cancel</span></button>
                            </a>
                            
                        </div>

                        <input type="hidden" name="fwd_uri" value="<?php echo $fwdURI; ?>" />
                        
                    </form>
                    
                    <div>
                   
                
                          
                    </div>
                </div>
            </div>
        </div> <!-- container -->
                        
        <?php include($_SERVER['APP_WEB_DIR'] . '/inc/site-footer.inc'); ?>

    </body>
</html>
