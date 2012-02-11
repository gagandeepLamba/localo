<?php
    //news/post/receiver.php
    include ('news-app.inc');
    include($_SERVER['APP_WEB_DIR'] . '/inc/header.inc');
    
    use com\indigloo\Util as Util;
    
    //add file path prefix
    
    $uploader = new com\indigloo\media\ImageUpload();
    
    /* media/application/year/month */
    $prefix = sprintf("%s/%s/%s/",'news',date('Y'),date('m')) ;
    $uploader->setPrefix($prefix);
    $uploader->process("Filedata");
    
    
    if ($uploader->hasError()) {
        
        $message = $uploader->getErrorMessage();
        $data = array('code' => 500, 'message' => $message);
        echo json_encode($data);
    
    } else {
        
        
        $mediaVO = new com\indigloo\news\view\Media();
        $mediaVO->mime =$uploader->getMime();
        $mediaVO->storeName = $uploader->getStoreName();
        $mediaVO->size = $uploader->getSize();
        $mediaVO->originalName = $uploader->getName();
        $mediaVO->height = $uploader->getHeight();
        $mediaVO->width = $uploader->getWidth();
        $mediaVO->bucket = 'media' ;
        
        
        $mediaDao = new com\indigloo\news\dao\Media();
        $mediaId = $mediaDao->add($mediaVO);
        $mediaVO->id  = $mediaId;
        
        
        $message = 'file upload done!';
        $data = array('code' => 0, 'mediaVO' => $mediaVO, 'message' => $message);
        echo json_encode($data);
    
    }



?>
