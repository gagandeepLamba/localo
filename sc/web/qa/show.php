<?php

    //sc/qa/show.php
    include ('sc-app.inc');
    include($_SERVER['APP_WEB_DIR'] . '/inc/header.inc');
    
    use com\indigloo\Util as Util;
    use com\indigloo\ui\form\Sticky;
    use com\indigloo\Constants as Constants;
    use com\indigloo\ui\form\Message as FormMessage;
     
    $sticky = new Sticky($gWeb->find(Constants::STICKY_MAP,true));
    
	$questionId = NULL ;
    if(!array_key_exists('id',$_GET) || empty($_GET['id'])) {
        trigger_error('question id is missing from request',E_USER_ERROR);
    } else {
        $questionId = $_GET['id'];
    }
    
    
    $questionDao = new com\indigloo\sc\dao\Question();
    $questionDBRow = $questionDao->getOnId($questionId);
    $imagesJson = $questionDBRow['images_json'];
    $images = json_decode($imagesJson);
    
    $answerDao = new com\indigloo\sc\dao\Answer();
    $answerDBRows = $answerDao->getOnQuestionId($questionId);

	if(is_null($gSessionUser)) {
		$user = \com\indigloo\auth\User::tryUserInSession();
		if(!is_null($user)) {
			$gSessionUser = $user ;
		}
	}
	

?>  

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>

       <head><title> 3mik.com - <?php echo $questionDBRow['title']; ?>  </title>
         

        <meta http-equiv="content-type" content="text/html; charset=ISO-8859-1" />

        <link rel="stylesheet" type="text/css" href="/3p/yui3/grids-min.css">
        <link rel="stylesheet" type="text/css" href="/css/sc.css">
        
        <script type="text/javascript" src="/3p/jquery/jquery-1.6.4.min.js"></script>
        <script type="text/javascript" src="/3p/jquery/jquery.tinycarousel.min.js"></script>
        <script type="text/javascript" src="/3p/jquery/jquery.validate.1.9.0.min.js"></script>
        <script type="text/javascript" src="/js/sc.js"></script>
			
        <script type="text/javascript">			
            $(document).ready(function(){				
                        
                $('#slider-code').tinycarousel({ pager: true });

				$("#web-form1").validate({
					errorLabelContainer: $("#web-form1 div.error") 
				});
				
				webgloo.sc.answer.attachEvents();
				webgloo.sc.answer.init();

                
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
                               
                           
                                <?php if(sizeof($images) > 0 ) { include('inc/slider.inc') ; } ?>
                            
                               
                                <div class="widget lightbg">
                                    <h2> <?php echo $questionDBRow['title'] ; ?> </h2>
                                    <div class="author">
                                       <span class="b"><a href="#"> <?php echo $questionDBRow['user_name'] ; ?> </a> </span>
                                       <span class="date">  posted on <?php echo Util::formatDBTime($questionDBRow['created_on']) ; ?> </span>
                                    </div>
                                        
                                     <div class="regular">
                                        <?php echo $questionDBRow['description'] ; ?>
                                     </div>
                                    
                                    <div class="mt20 tags"> Tags&nbsp;<?php echo $questionDBRow['tags']; ?> </div>
                                    
                                </div>
								
								<?php echo \com\indigloo\sc\html\Question::getEditBar($gSessionUser,$questionDBRow) ; ?>
								
                                <div class="mt20 thick-dashed-border">
									<h3> &nbsp; </h3>
								</div>
								<div class="orange-button" style="width:auto;float:right"> <a href="#form-wrapper">Answer this Question</a> </div>
								<div class="ml40">
									<?php
										foreach($answerDBRows as $answerDBRow) {
											echo \com\indigloo\sc\html\Answer::getSummary($gSessionUser,$answerDBRow) ;
										}
										
									?>
								</div>

                                <br/>

                                <?php FormMessage::render(); ?>
                                <div id="form-wrapper">
                                    <form id="web-form1"  name="web-form1" action="/qa/form/answer.php" enctype="multipart/form-data"  method="POST">
    
                                        <div class="error">  </div>
    
                                        <table class="form-table">
                                            <tr>
                                                <td class="field">Your Answer&nbsp;|&nbsp;<a id="open-link" href="#form-wrapper">Add Link</a></td>
                                                
                                             </tr>
											
                                             <tr>
                                                <td>
                                                    <textarea  name="answer" class="required h130" title="Answer is required" cols="50" rows="4" ><?php echo $sticky->get('answer'); ?></textarea>
                                                </td>
                                             </tr>
											 <tr>
												<td> <div id="link-data"> </div> </td> 
											</tr>
											
                                        </table>
										
										<div id="link-container" class="hide-me">
                                            <div id="message"> </div>
                                            <p> Use a url shortening service like goo.gl to shorten long urls</p>
                                            Link*&nbsp;<input  id="link-box"  type="text" name="link"  value="" />
                                            &nbsp; <button class="form-button" id="add-link">Add</button>
                                            
                                        </div>
										<hr>
                                         <div class="button-container">
                                            <button class="form-button" type="submit" name="save" value="Save" onclick="this.setAttribute('value','Save');" ><span>Save</span></button>
                                             <a href="/">
                                                <button class="form-button" type="button" name="cancel"><span>Cancel</span></button>
                                            </a>
                                            
                                        </div>

                                       <input type="hidden" name="question_id" value="<?php echo $questionDBRow['id']; ?>" />
									   <input type="hidden" name="q" value="<?php echo $_SERVER['REQUEST_URI']; ?>" />
                                       <input type="hidden" name="links_json" value='[]' />
									   
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
