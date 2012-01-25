<?php
    //qa/form/ask.php
    
    include 'sc-app.inc';
    include($_SERVER['APP_WEB_DIR'] . '/inc/header.inc');
     
    use \com\indigloo\ui\form as Form;
    use \com\indigloo\Constants as Constants ;
    use \com\indigloo\Util as Util ;
    
    if (isset($_POST['save']) && ($_POST['save'] == 'Save')) {
        
        $fhandler = new Form\Handler('web-form-1', $_POST);
        $fhandler->addRule('question', 'Question', array('required' => 1, 'maxlength' => 128));
        $fhandler->addRule('tags', 'Tags', array('required' => 1));
        $fhandler->addRule('location', 'Location', array('required' => 1));
        
        $fvalues = $fhandler->getValues();
        
        $ferrors = $fhandler->getErrors();
    
        
        if ($fhandler->hasErrors()) {
            $locationOnError = '/qa/ask.php' ;
            $gWeb->store(Constants::STICKY_MAP, $fvalues);
            $gWeb->store(Constants::FORM_ERRORS,$fhandler->getErrors());
            
            header("location: " . $locationOnError);
            exit(1);
        } else {
            
            $questionDao = new com\indigloo\sc\dao\Question();
            $data = $questionDao->create($fvalues['question'],
                                $fvalues['description'],
                                $fvalues['category'],
                                $fvalues['location'],
                                $fvalues['tags'],
                                $_POST['links_json'],
                                $_POST['images_json']);
    
            $code = $data['code'];
            
            if ($code == com\indigloo\mysql\Connection::ACK_OK ) {
                $locationOnSuccess = '/qa/thanks.php';
                header("location: " . $locationOnSuccess);
                
            } else {
                $message = sprintf("DB Error: (code is %d) please try again!",$code);
                $gWeb->store(Constants::STICKY_MAP, $fvalues);
                $gWeb->store(Constants::FORM_ERRORS,array($message));
                $locationOnError = '/qa/ask.php' ;
                header("location: " . $locationOnError);
                exit(1);
            }
            
           
        }
        
    }
?>