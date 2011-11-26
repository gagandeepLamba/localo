<?php
    //post/form/add.php
    
    include 'news-app.inc';
    include($_SERVER['APP_WEB_DIR'] . '/inc/header.inc');

    
    use com\indigloo\ui\form as Form;
    
    if (isset($_POST['save']) && ($_POST['save'] == 'Save')) {
        
        $fhandler = new Form\Handler('web-form-1', $_POST);
        $fhandler->addRule('title', 'Title', array('required' => 1));
        $fhandler->addRule('summary', 'Summary', array('required' => 1));
        
        $fvalues = $fhandler->getValues();
        $ferrors = $fhandler->getErrors();
    
        
        if ($fhandler->hasErrors()) {
            $locationOnError = '/post/add.php' ;
            $gWeb->store('sticky_map', $fvalues);
            $gWeb->store('form_errors',$fhandler->getErrors());
            header("location: " . $locationOnError);
            exit(1);
        } else {
            
            $postDao = new com\indigloo\news\dao\Post();
            $data = $postDao->create($fvalues['title'],
                                $fvalues['summary'],
                                $fvalues['description']);
    
            $code = $data['code'];
            
            if ($code != com\indigloo\mysql\Connection::ACK_OK ) {
                trigger_error("Error in Database operation");
            }
            
            $locationOnSuccess = '/post/edit-media.php?g_post_id='.$data['lastInsertId'] ;
            header("location: " . $locationOnSuccess);
        }
    }
?>