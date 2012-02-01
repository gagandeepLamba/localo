<?php
    //user/form/add.php
    
    include 'sc-app.inc';
    include($_SERVER['APP_WEB_DIR'] . '/inc/header.inc');
    include($_SERVER['APP_WEB_DIR'] . '/inc/auth.inc');
    
    use com\indigloo\ui\form as Form;
    use com\indigloo\Constants as Constants ;
    
    $data = $_POST['data'];
    $data = trim($data);
    
    //store
    $userDao = new com\indigloo\sc\dao\User();
    $userDBRow = $userDao->getUserInSession();
    $email = $userDBRow['email'];
    $userDao->updateInterest($email,$data);
    
    //store new user in session now
    $userDBRow['interests'] = $data ;
    $userDao->setUserInSession($userDBRow);
    
    echo "Preferences saved!!";
    
?>