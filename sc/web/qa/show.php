<?php

    //sc/index
    include ('sc-app.inc');
    include($_SERVER['APP_WEB_DIR'] . '/inc/header.inc');
    
    use com\indigloo\Util;
    use com\indigloo\ui\form\Sticky;
    use com\indigloo\Constants as Constants;
    use com\indigloo\ui\form\Message as FormMessage;
     
    $sticky = new Sticky($gWeb->find(Constants::STICKY_MAP,true));
    
	$noteId = NULL ;
    if(!array_key_exists('id',$_GET)) {
        trigger_error('REQ missing id',E_USER_ERROR);
    } else {
        $noteId = $_GET['id'];
    }
    
    
    $noteDao = new com\indigloo\sc\dao\Note();
    $noteDBRow = $noteDao->getOnId($noteId);
    $imagesJson = $noteDBRow['images_json'];
    $images = json_decode($imagesJson);
    
?>  

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>

       <head><title> 3mik.com - Home page  </title>
         

        <meta http-equiv="content-type" content="text/html; charset=ISO-8859-1" />

        <link rel="stylesheet" type="text/css" href="/3p/yui3/grids-min.css">
        <link rel="stylesheet" type="text/css" href="/css/sc.css">
        
        <script type="text/javascript" src="/3p/jquery/jquery-1.6.4.min.js"></script>
        <script type="text/javascript" src="/3p/jquery/jquery.tinycarousel.min.js"></script>
        
        <script type="text/javascript">			
            $(document).ready(function(){				
                        
                $('#slider-code').tinycarousel({ pager: true });
                
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
                            
                               
                                <div class="widget bbd5 p20">
                                    <h2> <?php echo $noteDBRow['title'] ; ?> </h2>
                                    <div class="details">
                                       <span class="b"> Posted by: <a href="#"> <?php echo $noteDBRow['user_id'] ; ?> </a> </span>
                                       <span class="date">  on <?php echo $noteDBRow['created_on'] ; ?> </span>
                                    </div>
                                        
                                     <div class="regular">
                                        <?php echo $noteDBRow['description'] ; ?>
                                     </div>
                                     <div class="mt20">
                                        <div style="color:#AAA;"> <?php echo $noteDBRow['tags']; ?> </div>
                                        <div style="color:#AAA;"> Time Line &dash;&nbsp;<?php echo $noteDBRow['timeline']; ?> </div>
                                        <span style="color:red"> + Interested in Deals</span>
                                        
                                    </div>
                                </div>
                               
                                <br/>
                               
                               
                                  <div class="action-links"> 
                                    <span class="grey-button"> <a href="#"> Forward</a> </span>
                                    &nbsp;
                                    <span class="grey-button"> <a href="#"> Bookmark</a> </span>
                                     &nbsp;
                                    <span class="grey-button"> <a href="#"> Tweet</a> </span>
                                 </div>
                                  
                                <div id="form-wrapper">
                                    <form id="web-form1"  name="web-form1" action="/qa/form/answer.php" enctype="multipart/form-data"  method="POST">
    
                                        <div class="error">  </div>
    
                                        <table class="form-table">
                                            <tr>
                                                <td class="field">Your Answer</td>
                                                
                                             </tr>
                                             <tr>
                                                
                                                <td>
                                                    <textarea  name="answer" class="h130" cols="50" rows="4" ><?php echo $sticky->get('answer'); ?></textarea>
                                                </td>
                                             </tr>
                                        </table>
                                         <div class="button-container">
                                            <button class="form-button" type="submit" name="save" value="Save" onclick="this.setAttribute('value','Save');" ><span>Save</span></button>
                                             <a href="/">
                                                <button class="form-button" type="button" name="cancel"><span>Cancel</span></button>
                                            </a>
                                            
                                        </div>
                                      
                                        
                                    </form>
                                </div> <!-- form wrapper -->
                               
                            </div> <!-- content -->


                        </div> <!-- u-2-3 -->
                        
                         <div class="yui3-u-1-3">
                            <!-- sidebar -->
							<?php include($_SERVER['APP_WEB_DIR'] . '/inc/sidebar.inc'); ?>
                        </div> <!-- u-1-3 -->
                        
                    </div> <!-- GRID -->


                </div> <!-- bd -->


              <div id="js-debug"> </div>
              
              
        </div> <!-- body wrapper -->
        <div id="ft">
            <?php include($_SERVER['APP_WEB_DIR'] . '/inc/site-footer.inc'); ?>
        </div>

    </body>
</html>
