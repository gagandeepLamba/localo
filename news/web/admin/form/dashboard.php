<?php
    //link/form/add.php
    
    include 'news-app.inc';
    include($_SERVER['APP_WEB_DIR'] . '/inc/header.inc');
    include($_SERVER['APP_WEB_DIR'] . '/inc/role/admin.inc');
    
    use com\indigloo\ui\form as Form;
    use com\indigloo\Constants as Constants ;
    
    if (isset($_POST['save']) && ($_POST['save'] == 'Save')) {
     
        $fhandler = new Form\Handler('web-form-1', $_POST,false);
        $json = $_POST['states_json'];
        
        $states = json_decode($json);
        $properties = get_object_vars($states);
        
        $acceptIds = array();
        $trashIds = array();
        
        
        foreach($properties as $key =>$value) {
            switch($value) {
                case 'A' :
                    array_push($acceptIds,$key);
                    break;
                case 'T' :
                    array_push($trashIds,$key);
                    break;
                default:
                    break;
            }
            
        }
        
        $postDao = new \com\indigloo\news\dao\Post();
           
        if(!empty($acceptIds)) {
            $postDao->updateLinkState($acceptIds,'A');
        }
        
        if(!empty($trashIds)) {
            $postDao->updateLinkState($trashIds,'T');
        }
        
        header("location: ". $_POST['back_uri']);
         
    }
    
?>