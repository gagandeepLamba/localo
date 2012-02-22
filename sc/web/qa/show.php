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

       
        <link rel="stylesheet" type="text/css" href="/3p/bootstrap/css/bootstrap.css">
        <link rel="stylesheet" type="text/css" href="/css/sc.css">
		<script type="text/javascript" src="/3p/jquery/jquery-1.7.1.min.js"></script>
		<script type="text/javascript" src="/3p/bootstrap/js/bootstrap.js"></script>
		
        <script type="text/javascript" src="/3p/jquery/jquery.validate.1.9.0.min.js"></script>

        <script type="text/javascript" src="/3p/json2.js"></script>
        <script type="text/javascript" src="/js/sc.js"></script>
			
        <script type="text/javascript">			
            $(document).ready(function(){				

				webgloo.media.init(["link"]);
				webgloo.media.attachEvents();

				$("#web-form1").validate({
					errorLabelContainer: $("#web-form1 div.error") 
				});

				$('#myCarousel').carousel({
				  interval: 2000
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
                           
				<?php if(sizeof($images) > 0 ) { include('inc/carousel.inc') ; } ?>
			
				<div class="widget well">
					 <div class="regular">
						<?php echo $questionDBRow['description'] ; ?>
					 </div>
					<div class="author">
					   <span class="b"><a href="#"> <?php echo $questionDBRow['user_name'] ; ?> </a> </span>
					   <span class="date">  posted on <?php echo Util::formatDBTime($questionDBRow['created_on']) ; ?> </span>
					</div>
					
					<div class="tags"> Tags&nbsp;<?php echo $questionDBRow['tags']; ?> </div>
					
				</div>
				
				<?php echo \com\indigloo\sc\html\Question::getEditBar($gSessionUser,$questionDBRow) ; ?>
				
				
				<div class="page-header">
					<h2>Comments </h2>
				</div>

				<div>
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
							<td>
								<textarea  name="answer" class="required h130 w500" title="Answer is required" cols="50" rows="4" ><?php echo $sticky->get('answer'); ?></textarea>
							</td>
						 </tr>
						 
						
					</table>
					
					 <div class="form-actions">
						<button class="btn btn-primary" type="submit" name="save" value="Save" onclick="this.setAttribute('value','Save');" ><span>Add your comment</span></button>
					</div>

				   <input type="hidden" name="question_id" value="<?php echo $questionDBRow['id']; ?>" />
				   <input type="hidden" name="q" value="<?php echo $_SERVER['REQUEST_URI']; ?>" />
				   
				</form>
				</div> <!-- wrapper -->
				
			</div>
		</div>
	</div> <!-- container -->
	
	<div id="ft">
		<?php include($_SERVER['APP_WEB_DIR'] . '/inc/site-footer.inc'); ?>
	</div>

    </body>
</html>
