<?php
    //post/form/edit.php
    
    include 'news-app.inc';
    include($_SERVER['APP_WEB_DIR'] . '/inc/header.inc');
    include($_SERVER['APP_WEB_DIR'] . '/inc/role/staff.inc');
    
    use \com\indigloo\ui\form as Form;
    use \com\indigloo\Constants as Constants ;
    use \com\indigloo\Util as Util ;
    
    if (isset($_POST['save']) && ($_POST['save'] == 'Save')) {
        
        $fhandler = new Form\Handler('web-form-1', $_POST,false);
        $fhandler->addRule('title', 'Title', array('required' => 1, 'maxlength' => 128));
        $fhandler->addRule('summary', 'Summary', array('required' => 1));
        
        $fvalues = $fhandler->getValues();
        
        if(!Util::isAlphaNumeric($fvalues['title'])){
            $fhandler->addError('Post title can contain letters and numbers only!');
        }
        
        $ferrors = $fhandler->getErrors();
        
        
        if ($fhandler->hasErrors()) {
            $locationOnError = '/post/edit.php?g_post_id='.$fvalues['post_id'] ;
            $gWeb->store(Constants::STICKY_MAP, $fvalues);
            $gWeb->store(Constants::FORM_ERRORS,$fhandler->getErrors());
            header("location: " . $locationOnError);
            exit(1);
        } else {
            
            $postDao = new com\indigloo\news\dao\Post();
            $data = $postDao->update($fvalues['post_id'],
                                $fvalues['title'],
                                $fvalues['summary'],
                                $fvalues['description']);
    
            $code = $data['code'];
            
             
            if ($code == com\indigloo\mysql\Connection::ACK_OK ) {
                header("location: / ");
            }
            
            if($code == com\indigloo\mysql\Connection::DUPLICATE_KEY ) {
                $gWeb->store(Constants::STICKY_MAP, $fvalues);
                $gWeb->store(Constants::FORM_ERRORS,array("Duplicate error : Did you try an existing title?"));
                $locationOnError = '/post/edit.php?g_post_id='.$fvalues['post_id'] ;
                header("location: " . $locationOnError);
                exit(1);
            }
            
        }
    }
?>