<?php

namespace webgloo\job\dao {

    use webgloo\job\view as view;
    use webgloo\job\mysql as mysql;
    use webgloo\common\Util as Util ;
    
    class Admin {

         function getRecords() {
            $rows = mysql\Admin::getRecords();
            return $rows;
        }
        
        function create($organizationId,$firstName, $lastName,$email,$password,$phone,$company,$title) {
            $adminVO = new view\Admin();
            $adminVO->firstName = $firstName;
            $adminVO->lastName = $lastName;

            $adminVO->email = $email;
            $adminVO->phone = $phone;
            $adminVO->company = $company;
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
