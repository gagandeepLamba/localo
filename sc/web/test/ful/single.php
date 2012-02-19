<?php

	//test page using valums ajax file uploader
	// http://valums.com/ajax-upload/
    //test/ful/single.php
    include ('sc-app.inc');
    include($_SERVER['APP_WEB_DIR'] . '/inc/header.inc');
    include($_SERVER['APP_WEB_DIR'] . '/inc/role/user.inc');
	
    use com\indigloo\Util;
    use com\indigloo\ui\form\Sticky;
    use com\indigloo\Constants as Constants;
    use com\indigloo\ui\form\Message as FormMessage;
     
    $sticky = new Sticky($gWeb->find(Constants::STICKY_MAP,true));
    
    $strImagesJson = $sticky->get('images_json') ;
    $strLinksJson = $sticky->get('links_json') ;
    
    $strImagesJson = empty($strImagesJson) ? '[]' : $strImagesJson ;
    $strLinksJson = empty($strLinksJson) ? '[]' : $strLinksJson ;

    
?>  

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>

       <head><title> 3mik.com - Share your find, need and knowledge</title>
         

       <meta http-equiv="content-type" content="text/html; charset=ISO-8859-1" />

		<link rel="stylesheet" type="text/css" href="/3p/yui3/grids-min.css">
		<link rel="stylesheet" type="text/css" href="/css/sc.css">
		<link rel="stylesheet" type="text/css" href="/3p/ful/valums/fileuploader.css">
		
		<script type="text/javascript" src="/3p/jquery/jquery-1.6.4.min.js"></script>
		<script type="text/javascript" src="/3p/jquery/jquery.validate.1.9.0.min.js"></script>
		
		 
		<script type="text/javascript" src="/3p/ful/valums/fileuploader.js" ></script>
		<script type="text/javascript" src="/js/sc.js"></script>
		<style type="text/css">
			.qq-upload-list {
				/* display :none ;*/
			}
		</style>
	  
        <script type="text/javascript">
       
            $(document).ready(function(){
              
				$("#web-form1").validate({
					   errorLabelContainer: $("#web-form1 div.error") 
				});
					
				webgloo.sc.question.attachEvents();
				webgloo.sc.question.init();
				  
				var uploader = new qq.FileUploader({
					element: document.getElementById('image-uploader'),
					action: '/test/ful/sr1.php',
					debug: true,
					onComplete: function(id, fileName, responseJSON) {
						console.log(responseJSON);
						 webgloo.sc.question.addImage(responseJSON.mediaVO);
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

                                    <h2> Share your find, need and knowledge </h2>


                                    <p class="help-text">
                                      &nbsp;

                                    </p>
                                    
                                    <?php FormMessage::render(); ?>
                            
                                    <div id="form-wrapper">
                                        <form id="web-form1"  name="web-form1" action="/share/form/add.php" enctype="multipart/form-data"  method="POST">

                                            <div class="error">    </div>

                                            <table class="form-table">
               
												  <tr>
                                                    <td class="field">&nbsp;</td>
                                                    <td>
														Category<span class="red-label">*</span> &nbsp;
														<?php
														    $selectBoxDao = new \com\indigloo\sc\dao\SelectBox();
														    $catRows = $selectBoxDao->get('CATEGORY');
															echo \com\indigloo\ui\SelectBox::render('category',$catRows);	   	   
																													
														?>
														<hr>
														<br>
                                                    </td>
                                                </tr>
												<tr>
                                                <td> &nbsp; </td>
                                                <td>
													<div id="image-uploader">		
														<noscript>			
															<p>Please enable JavaScript to use file uploader.</p>
															<!-- or put a simple form for upload here -->
														</noscript>         
													</div>
			
                                                 </td>
                                                 
                                                </tr>
												
												
                                                <tr>
													<td class="field">&nbsp;</td>
													<td>
														
														<textarea  name="description" class="h130 w500" cols="50" rows="4" ><?php echo $sticky->get('description'); ?></textarea>
													</td>
                                                 </tr>
                        
                                                
                                                 <tr>
                                                 <td> &nbsp; </td>
                                                 <td>
                                                        <div id="link-data"> </div>
                                                        <div id="media-data"> </div>
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
                                            <input type="hidden" name="links_json" value='<?php echo $strLinksJson ; ?>' />
                                            <input type="hidden" name="images_json" value='<?php echo $strImagesJson ; ?>' />
                                            
                                        </form>
                                    </div> <!-- form wrapper -->
                                   
                                   
                            </div> <!-- content -->


                        </div> 
                        
                         <div class="yui3-u-1-3">
                             <?php include($_SERVER['APP_WEB_DIR'] .'/qa/sidebar/ask.inc'); ?>
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
