
<?php
    use com\indigloo\auth\FormAuthentication ;
    use com\indigloo\html\template\Flexy ;


    if(FormAuthentication::tryUserRole()) {
        //we have a user session runnning
        $userVO = FormAuthentication::getLoggedInUser();
        $flexy = Flexy::getInstance();
        $flexy->compile('/toolbar/user.tmpl');
        $html = $flexy->bufferedOutputObject($userVO);
        echo $html;
    }else if(FormAuthentication::tryAdminRole()) {
        //we have a user session runnning
        $adminVO = FormAuthentication::getLoggedInAdmin();
        $flexy = Flexy::getInstance();
        $flexy->compile('/toolbar/admin.tmpl');
        $html = $flexy->bufferedOutputObject($adminVO);
        echo $html;
    } else {
        $flexy = Flexy::getInstance();
        $flexy->compile('/toolbar/default.tmpl');
        
        $view = new stdClass ;
        $html = $flexy->bufferedOutputObject($view);
        echo $html;
    }

    
?>

       
