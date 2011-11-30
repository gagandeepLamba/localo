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
        Util::isEmpty('post_id', $postId);
        
        
        $mediaVO = new com\indigloo\news\view\Media();
        $mediaVO->mime =$uploader->getMime();
        $mediaVO->storeName = $uploader->getStoreName();
        $mediaVO->size = $uploader->getSize();
        $mediaVO->originalName = $uploader->getName();
        $mediaVO->height = $uploader->getHeight();
        $mediaVO->width = $uploader->getWidth();
        $mediaVO->bucket = 'media' ;
        
        
        $mediaDao = new com\indigloo\news\dao\Media();
        $mediaId = $mediaDao->add($postId,$mediaVO);
        $mediaVO->id  = $mediaId;
        $mediaVO->postId = $postId;
        
        $dimensions = Util::getScaledDimensions($mediaVO->width,$mediaVO->height,320);
        $mediaVO->height = $dimensions['height'];
        $mediaVO->width = $dimensions['width'];
        
        $message = 'file upload done!';
        $data = array('code' => 0, 'mediaVO' => $mediaVO, 'message' => $message);
        echo json_encode($data);
    
    }



?>
