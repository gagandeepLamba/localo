<?php

    include ('news-app.inc');
    include($_SERVER['APP_WEB_DIR'] . '/inc/header.inc');
    use com\indigloo\Util as Util;
    
    $uploader = new com\indigloo\media\ImageUpload();
    $uploader->process("Filedata");
    
    
    if ($uploader->hasError()) {
        
        $message = $uploader->getErrorMessage();
        $data = array('code' => 500, 'message' => $message);
        echo json_encode($data);
    
    } else {
        
        $postId = $_POST['entity_id'];
        $image = new stdClass ;
        
        $image->name = $uploader->getName();
        $image->storeName = $uploader->getStoreName();
        
        $dimensions = Util::getScaledDimensions($uploader->getWidth(),$uploader->getHeight(),320);
        
        $image->height = $dimensions['height'];
        $image->width = $dimensions['width'];
        
        $message = 'file upload done!';
        $data = array('code' => 0, 'image' => $image, 'message' => $message);
        echo json_encode($data);
    
    }



?>
