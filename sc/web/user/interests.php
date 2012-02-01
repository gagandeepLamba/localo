<?php

    //sc/index
    include ('sc-app.inc');
    include($_SERVER['APP_WEB_DIR'] . '/inc/header.inc');
    include($_SERVER['APP_WEB_DIR'] . '/inc/auth.inc');
    
    use com\indigloo\Util;
    $catDao = new com\indigloo\sc\dao\Category();
	$catRows = $catDao->getAll();
    
    
	
?>  

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>

       <head><title> 3mik.com - Home page  </title>
         

        <meta http-equiv="content-type" content="text/html; charset=ISO-8859-1" />

        <link rel="stylesheet" type="text/css" href="/3p/yui3/grids-min.css">
        <link rel="stylesheet" type="text/css" href="/css/sc.css">
       
	    <script type="text/javascript" src="/3p/jquery/jquery-1.6.4.min.js"></script>
        <script type="text/javascript" src="/3p/jquery/jquery.validate.1.9.0.min.js"></script>
	   
	    <script>
			  $(document).ready(function(){
                
                $("a.add-me").click(function(event){
					 event.preventDefault();
					 var name = $(this).attr("name");
					 var node = $(this).parent();
					 $("#selected").append(node);
					 $("#selected .add-me").remove();
					 $("#selected #"+name).append('<a class="remove-me" href="">Remove</a>');
			  }) ;
				
			  $("a.remove-me").click(function(event){
					 event.preventDefault();
					 var name = $(this).attr("name");
					 var node = $(this).parent();
					 $("#media-data").append(node);
					 $("#media-data .remove-me").remove();
					 $("#media-data #"+name).append('<a class="add-me" href="">Add</a>');
			  }) ;
				
			  $("#save-selection").click(function(event){
                    event.preventDefault();
                    
                    try{
                        var dataObj = {};
                        var strCats = '';
                        
                        $("#selected").find('.previewImage').each(function(index) {
                            var name = $(this).attr("id");
                            strCats = strCats + name + " " ;
                            
                        });
                        
                        dataObj.data = strCats;
                        
                        $.ajax({
                            url: '/user/form/interests.php' ,
                            type: 'POST',
                            dataType: 'html',
                            data : dataObj,
                            timeout: 9000,
                
                            error: function(XMLHttpRequest, textStatus){
                                alert("Ajax error :: " + textStatus);
                            },
                            success: function(html){
                                alert(html);
                            }
                        }); 
					 } catch(ex) {
						alert("Error:: " + ex.toString());
					 }
			  }) ;
				
            });
       
		
		</script>
       
    </head>

    <body>
        <?php
            include($_SERVER['APP_WEB_DIR'] . '/inc/toolbar.inc');
            $selectedRows = array();
            //print_r($userDBRow);
            //exit ;
           
            if(!empty($userDBRow) && !empty($userDBRow['interests'])) {
                
                $strInterests = $userDBRow['interests'];
                
                
                $strInterests = trim($strInterests);
                $pieces = explode(" ",$strInterests);
                
                foreach($pieces as $piece){
                    if(!empty($piece)) {
                        array_push($selectedRows,$piece);
                    }
                }
            }
            
        ?>
        <div id="body-wrapper">
				
                <div id="hd">
                    <?php include($_SERVER['APP_WEB_DIR'] . '/inc/banner.inc'); ?>
                </div>
				
                <div id="bd">

                    <div class="yui3-g">
                       
                
                        <div class="yui3-u-2-3">
                            <div id="content">
								   <h2> Please select your interests </h2>
								  
								   <div id="media-data">
										  <?php
												 foreach($catRows as $name => $image) {
														if(!in_array($name,$selectedRows)) {
															   $html = \com\indigloo\sc\html\Category::get($name,$image);
															   echo $html ;
														}
												 }
										  ?>
										  	 
								   </div>
								   
								   
                            </div> <!-- content -->


                        </div> <!-- u-2-3 -->
                        
                         <div class="yui3-u-1-3">
                            <div id="selected" style="border-left:1px solid #CCC;min-height:600px;padding:20px;">
								   <p>
								   Your selection will appear here. Press the Save button after you are done.
								   </p>
								   
								   <br/>
								   <div class="orange-button">
										  <a id="save-selection" href=""> Save </a>
								   </div>
								   
								   <?php
										  foreach($selectedRows as $selected) {
												 $html = \com\indigloo\sc\html\Category::get($selected,$catRows[$selected],'REM');
												 echo $html ; 
										  }
								   ?>
								   
							</div>
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
