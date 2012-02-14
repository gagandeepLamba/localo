<?php

    //sc/user/profile/edit.php
    include ('sc-app.inc');
    include($_SERVER['APP_WEB_DIR'] . '/inc/header.inc');
    include($_SERVER['APP_WEB_DIR'] . '/inc/role/user.inc');
	 
    use com\indigloo\Util;
    use com\indigloo\ui\form\Sticky;
    use com\indigloo\Constants as Constants;
    use com\indigloo\ui\form\Message as FormMessage;
     
    $sticky = new Sticky($gWeb->find(Constants::STICKY_MAP,true));
	
	if(is_null($gSessionUser)) {
		$gSessionUser = \com\indigloo\auth\User::getUserInSession();
	}
	
	$userId = $gSessionUser->id ;
    $userDao = new \com\indigloo\sc\dao\User() ;
	$userDBRow = $userDao->getonId($userId);
   
?>  

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>

       <head><title> Edit Profile - <?php echo $userDBRow['first_name']; ?>  </title>
         

        <meta http-equiv="content-type" content="text/html; charset=ISO-8859-1" />

        <link rel="stylesheet" type="text/css" href="/3p/yui3/grids-min.css">
        <link rel="stylesheet" type="text/css" href="/css/sc.css">
       
	    <script type="text/javascript" src="/3p/jquery/jquery-1.6.4.min.js"></script>
        <script type="text/javascript" src="/3p/jquery/jquery.validate.1.9.0.min.js"></script>


        <script type="text/javascript">
            $(document).ready(function(){
                $("#web-form1").validate({
                    errorLabelContainer: $("#web-form1 div.error"),
                    rules: {
                        password: "required"
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
								 <h1> Edit Profile - <?php echo $userDBRow['first_name']; ?> </h1>
								 <hr>

                                    <p class="help-text">
                                       Please update the details and click on Save.

                                    </p>
                                    
                                    <?php FormMessage::render(); ?>
                            
                                    <div id="form-wrapper">
                                        <form id="web-form1"  name="web-form1" action="/user/profile/form/edit.php" enctype="multipart/form-data"  method="POST">

                                            <div class="error">    </div>

                                            <table class="form-table">

                                                 <tr>
                                                    <td class="field">First Name<span class="red-label">*</span></td>
                                                    <td>
                                                        <input type="text" name="first_name" maxlength="32" class="required" title="&nbsp;First Name is required" value="<?php echo $sticky->get('first_name',$userDBRow['first_name']); ?>"/>
                                                    </td>
                                                 </tr>
												  <tr>
                                                    <td class="field">Last Name<span class="red-label">*</span></td>
                                                    <td>
                                                        <input type="text" name="last_name" maxlength="32" class="required" title="&nbsp;Last Name is required" value="<?php echo $sticky->get('last_name',$userDBRow['last_name']); ?>"/>
                                                    </td>
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


                        </div>
                        
                         <div class="yui3-u-1-3">
                             <?php include('sidebar/edit.inc'); ?>
                        </div> 
                        
                    </div>


                </div> <!-- bd -->


              <div id="js-debug"> </div>
              
              
        </div> <!-- body wrapper -->
        <div id="ft">
            <?php include($_SERVER['APP_WEB_DIR'] . '/inc/site-footer.inc'); ?>
        </div>

    </body>
</html>
