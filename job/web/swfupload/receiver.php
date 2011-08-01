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
   
    //send a json encoded response to JAVASCRIPT handler
    $document = new webgloo\job\view\Document();
   
    $document->originalName = $uploader->getName();
    $document->storeName = $uploader->getStoreName();
    $document->size = $uploader->getSize();
    $document->mime = $uploader->getMime();
    //save in DB
    $documentDao = new webgloo\job\dao\Document();
    $data = $documentDao->create($document);
    //get last insert id
    $document->uuid = $data['lastInsertId'];

    $code = 1;
    //send back
    $message = 'file upload done!';
    $data = array('code' => 1, 'document' => $document, 'message' => $message);
    echo json_encode($data);

}



?>