<?php
    //link/form/edit.php
    
    include 'news-app.inc';
    include($_SERVER['APP_WEB_DIR'] . '/inc/header.inc');
     
    use com\indigloo\ui\form as Form;
    use com\indigloo\Constants as Constants ;
    
    if (isset($_POST['save']) && ($_POST['save'] == 'Save')) {
        
        $fhandler = new Form\Handler('web-form-1', $_POST);
        $fhandler->addRule('title', 'Title', array('required' => 1));
        $fhandler->addRule('summary', 'Summary', array('required' => 1));
        $fhandler->addRule('link', 'Link', array('required' => 1));
        
        $fvalues = $fhandler->getValues();
        $ferrors = $fhandler->getErrors();
        
        
        if ($fhandler->hasErrors()) {
            $locationOnError = '/link/edit.php?g_post_id='.$fvalues['post_id']; 
            $gWeb->store(Constants::STICKY_MAP, $fvalues);
            $gWeb->store(Constants::FORM_ERRORS,$fhandler->getErrors());
            
            header("location: " . $locationOnError);
            exit(1);
            
        } else {
            
            $postDao = new com\indigloo\news\dao\Post();
            $data = $postDao->updateLink($fvalues['post_id'],
                                $fvalues['title'],
                                $fvalues['summary'],
                                $fvalues['link']);
    
            $code = $data['code'];
            
            if ($code == com\indigloo\mysql\Connection::ACK_OK ) {
                header("location: /");
            }
            
            if($code == com\indigloo\mysql\Connection::DUPLICATE_KEY ) {
                $gWeb->store(Constants::STICKY_MAP, $fvalues);
                $gWeb->store(Constants::FORM_ERRORS,array("Duplicate error : Did you try an existing title?"));
                $locationOnError = '/link/edit.php?g_post_id='.$fvalues['post_id']; 
                header("location: " . $locationOnError);
                exit(1);
            }
            
        }
    }
?>