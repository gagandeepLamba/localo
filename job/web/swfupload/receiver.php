<?php

include ('job-app.inc');
include ($_SERVER['APP_LIB_DIR'] . '/error.inc');

//upload job FileUpload to process document!
use webgloo\job\FileUpload;

$uploader = new FileUpload();
$uploader->process("Filedata");


if ($uploader->hasError()) {
    //known errors during file upload
    $message = $uploader->getErrorMessage();
    $data = array('code' => -1, 'error' => 'yes', 'message' => $message);
    echo json_encode($data);

} else {
    //file upload success
    //send back document data
    $code = 1;
    //send a json encoded response to JAVASCRIPT handler
    $document = new webgloo\job\view\Document();
    $document->uuid = rand();
    $document->originalName = $uploader->getName();
    $document->storeName = $uploader->getStoreName();
    $document->size = $uploader->getSize();
    $document->mime = $uploader->getMime();
    //send back
    $message = 'file uploade is success';
    $data = array('code' => 1, 'document' => $document, 'message' => $message);
    echo json_encode($data);

}



?>