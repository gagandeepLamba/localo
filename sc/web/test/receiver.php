<?php

    include ('sc-app.inc');
    include($_SERVER['APP_WEB_DIR'] . '/inc/header.inc');
    
    use com\indigloo\Util as Util;
    
    $uploader = new com\indigloo\media\ImageUpload();
    $uploader->process("Filedata");
    
    
    if ($uploader->hasError()) {
        
        $message = $uploader->getErrorMessage();
        $data = array('code' => 500, 'message' => $message);
        echo json_encode($data);
    
    } else {
        
        $message = 'file upload done!';
        $data = array('code' => 0, 'message' => $message);
        echo json_encode($data);
    
    }



?>
