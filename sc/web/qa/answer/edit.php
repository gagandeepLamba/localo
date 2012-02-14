<?php

    //sc/qa/answer/edit.php
    include ('sc-app.inc');
    include($_SERVER['APP_WEB_DIR'] . '/inc/header.inc');
    include($_SERVER['APP_WEB_DIR'] . '/inc/role/user.inc');
	 
    use com\indigloo\Util;
    use com\indigloo\ui\form\Sticky;
    use com\indigloo\Constants as Constants;
    use com\indigloo\ui\form\Message as FormMessage;
     
    $sticky = new Sticky($gWeb->find(Constants::STICKY_MAP,true));
    
    $answerId = NULL ;
	
    if(!array_key_exists('id',$_GET) || empty($_GET['id'])) {
        trigger_error('answer id is missing from request',E_USER_ERROR);
    } else {
        $answerId = $_GET['id'];
    }
    
    $answerDao = new com\indigloo\sc\dao\Answer();
    $answerDBRow = $answerDao->getOnId($answerId);

	$sticky = new Sticky($gWeb->find(Constants::STICKY_MAP,true));
    
    
?>  

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>

       <head><title> Edit Answer</title>
         

        <meta http-equiv="content-type" content="text/html; charset=ISO-8859-1" />

        <link rel="stylesheet" type="text/css" href="/3p/yui3/grids-min.css">
        <link rel="stylesheet" type="text/css" href="/css/sc.css">
        
       
        <script type="text/javascript">
       
            $(document).ready(function(){
                
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

                                    <h1> Edit Answer </h1>
									<hr>


                                    <p class="help-text">
                                       Please update your answer and click Save.

                                    </p>
                                    
                                    <?php FormMessage::render(); ?>
                            
                                    <div id="form-wrapper">
                                        <form id="web-form1"  name="web-form1" action="/qa/answer/form/edit.php" enctype="multipart/form-data"  method="POST">

                                            <div class="error">    </div>

                                            <table class="form-table">

                                        
                                                 <tr>
                                                    <td class="field">Your Answer</td>
												 </tr>
												 <tr>
													<td>
														<textarea  name="answer" class="w580 h280 required" cols="60" rows="10" ><?php echo $sticky->get('answer',$answerDBRow['answer']); ?></textarea>
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
                                        
                                            <input type="hidden" name="answer_id" value="<?php echo $answerDBRow['id'] ; ?>" />
                                            <input type="hidden" name="question_id" value="<?php echo $answerDBRow['question_id'] ; ?>" />
											
                                        </form>
                                    </div> <!-- form wrapper -->
                                   
                                   
                            </div> <!-- content -->


                        </div> 
                        
                         <div class="yui3-u-1-3">
                          <!-- sidebar -->
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
