<?php

namespace com\mik3\dao {

    use com\mik3\view as view;
    use com\mik3\mysql as mysql;
    use com\indigloo\Util as Util ;
    
    class Admin {

         function getRecords($organizationId) {
            $rows = mysql\Admin::getRecords($organizationId);
            return $rows;
        }
        
        function create($organizationId,$name,$email,$password,$phone,$title) {
            $adminVO = new view\Admin();
            $adminVO->name = $name;
            $adminVO->email = $email;
            $adminVO->phone = $phone;
            $adminVO->title = $title;
            $adminVO->organizationId = $organizationId;
            //store into DB layer
            //password is not part of adminVO
            mysql\Admin::create($adminVO,$password);
        }
        
        function logonAdmin($email, $password) {
            Util::isEmpty('Email', $email);
            Util::isEmpty('Password', $password);
            $data = mysql\Admin::logonAdmin($email, $password);
            return $data;
            
        }

    }

}
?>
