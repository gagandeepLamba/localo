<?php



function webgloo_error_handler($errorno,$errorstr,$file,$line) {

    if(error_reporting() == 0 ) {
        // do nothing for silenced errors
        return true ;
    }
    
    

    switch($errorno) {

        case E_STRICT :
        //do nothing
        // PEAR packages use PHP-4 compatible code that throws
        // errors in E_STRICT mode
            return true;
        case E_NOTICE :
        case E_USER_NOTICE :
            webgloo\common\Logger::getInstance()->error(" $file :: $line :: $errorstr");
            break ;
        case E_USER_ERROR:
            //E_USER_ERROR are not necessarily well defined errors
            //so we cannot just display back those errors
            //Also we cannot assume that loggin has been done.
            //so we just let it be the default error case!
            
        default:
            ob_start();
            debug_print_backtrace();
            $trace = ob_get_contents();
            @ ob_end_clean();
            //debug_print_backtrace();
            webgloo\common\Logger::getInstance()->trace($file,$line,$errorstr,$trace);
            //send generic json encoded message back to UI
            $message = "Internal server error happened.Please check log for details!";
            $error = array('code' => -1, 'error' => 'yes', 'message' => $message);
            echo json_encode($error) ;
            //Imp:Finally error handler should die
            exit(1);
            break ;

    }

    //do not execute PHP error handler
    return true ;
}

//set our own error handler
set_error_handler('webgloo_error_handler');
ob_start();



?>