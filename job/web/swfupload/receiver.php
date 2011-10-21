<?php

include ('job-app.inc');
include($_SERVER['APP_WEB_DIR'] . '/inc/header.inc');

//upload job FileUpload to process document!

$uploader = new com\mik3\FileUpload();
$uploader->process("Filedata");


if ($uploader->hasError()) {
    //known errors during file upload
    $message = $uploader->getErrorMessage();
    $data = array('code' => -1, 'error' => 'yes', 'message' => $message);
    echo json_encode($data);

} else {
    //file upload success

    //swfupload control should have sent application_id in _POST
    $applicationId = $_POST['application_id'];
    //send a json encoded response to JAVASCRIPT handler
    //send back document data
    $document = new com\mik3\view\Document();
   
    $document->originalName = $uploader->getName();
    $document->storeName = $uploader->getStoreName();
    $document->size = $uploader->getSize();
    $document->mime = $uploader->getMime();
    //entity name and id
    $document->entityName = $_POST['entity_name'];
    $document->entityId = $_POST['entity_id'];
    //save in DB
    $documentDao = new com\mik3\dao\Document();
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
