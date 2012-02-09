<?php
    //link/form/add.php
    
    include 'news-app.inc';
    include($_SERVER['APP_WEB_DIR'] . '/inc/header.inc');
     
    use com\indigloo\ui\form as Form;
    use com\indigloo\Constants as Constants ;
    
    if (isset($_POST['save']) && ($_POST['save'] == 'Save')) {
     
        $fhandler = new Form\Handler('web-form-1', $_POST,false);
        $json = $_POST['states_json'];
        echo $json; exit ;
        
        //header("location: /admin/dashboard.php" );
         
    }
    
?>