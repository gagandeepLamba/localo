<?php

	//test/ful/sr1.php
    include ('sc-app.inc');
    include($_SERVER['APP_WEB_DIR'] . '/inc/header.inc');
    set_error_handler('webgloo_ajax_error_handler');
	
    use com\indigloo\Util as Util;
    /* 
    file_put_contents(  
        'uploads/' . $fn,  
        file_get_contents('php://input')  
    );*/
	
	
	
    
	$uploader = new com\indigloo\media\ImageUpload($store);
		
	if (isset($_GET['qqfile'])) {
		$pipe = new \com\indigloo\media\XHRUpload();
		
		$store = new \com\indigloo\media\FileUpload($pipe);
		$prefix = sprintf("%s/%s/",'sc',date('Y/m/d')) ;
		$store->setPrefix($prefix);
		
		$uploader = new com\indigloo\media\ImageUpload($store);
		$uploader->process($_GET['qqfile']);
		
	} elseif (isset($_FILES['qqfile'])) {
		$pipe = new \com\indigloo\media\Upload();
		
		$store = new \com\indigloo\media\FileUpload($pipe);
		$prefix = sprintf("%s/%s/",'sc',date('Y/m/d')) ;
		$store->setPrefix($prefix);
		
		$uploader = new com\indigloo\media\ImageUpload($store);
		$uploader->process("qqfile");
		
	} else {
		trigger_error("what is this?", E_USER_ERROR); 
	}


	$errors = $uploader->getErrors() ;

    if (sizeof($errors) > 0 ) {
        $data = array('code' => 500, 'error' => $errors[0]);
        echo json_encode($data);
    
    } else {
        
        $mediaVO = $uploader->getMediaData();
        $mediaVO->bucket = 'media' ;
        
        $mediaDao = new com\indigloo\sc\dao\Media();
        $mediaId = $mediaDao->add($mediaVO);
        $mediaVO->id  = $mediaId;
        
        $message = 'file upload done!';
        $data = array('code' => 0, 'mediaVO' => $mediaVO, 'message' => $message,'success' => true);
        echo json_encode($data);
    
    }
	
	
	/*
	$path = $_GET['qqfile'];
	$path = "/Users/rjha/web/upload/ful/".$path;
	
	$input = fopen("php://input", "r");
	$temp = tmpfile();
	$realSize = stream_copy_to_stream($input, $temp);
	fclose($input);
	
	$target = fopen($path, "w+");        
	fseek($temp, 0, SEEK_SET);
	stream_copy_to_stream($temp, $target);
	fclose($target);

	$message = 'file upload done!';
	//valums ajax upload script requires success to be true
	// array('success'=>true);
	// encode error messages with an error key
	// array('error'=> 'message')
	
	$data = array('code' => 0, 'message' => $message, 'success' => true);
	echo json_encode($data);
	*/
	

?>
