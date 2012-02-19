<?php
    //news/post/receiver.php
    include ('news-app.inc');
    include($_SERVER['APP_WEB_DIR'] . '/inc/header.inc');
    
    use com\indigloo\Util as Util;
    
     
    $pipe = new \com\indigloo\media\Upload();
    
    $store = new \com\indigloo\media\FileUpload($pipe);
    /* upload_path/ + application/ + year/month/date/ */
    $prefix = sprintf("%s/%s/",'news',date('Y/m/d')) ;
    $store->setPrefix($prefix);
    
    $uploader = new com\indigloo\media\ImageUpload($store);
    $uploader->process("Filedata");
    
    $errors = $uploader->getErrors() ;

    
    if (sizeof($errors) > 0 ) {
        $data = array('code' => 500, 'message' => $errors[0]);
        echo json_encode($data);
    
    } else {
        
        $mediaVO = $uploader->getMediaData();
        $mediaVO->bucket = 'media' ;
        
        $mediaDao = new com\indigloo\news\dao\Media();
        $mediaId = $mediaDao->add($mediaVO);
        $mediaVO->id  = $mediaId;
        
        
        $message = 'file upload done!';
        $data = array('code' => 0, 'mediaVO' => $mediaVO, 'message' => $message);
        echo json_encode($data);
    
    }



?>
