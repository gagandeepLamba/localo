<?php

namespace webgloo\job\dao {

    use webgloo\job\view as view;
    use webgloo\job\mysql as mysql;
    use webgloo\common\Util as Util ;
    
    class User {

        function getRecords() {
            $rows = mysql\User::getRecords();
            return $rows;
        }

        function create($name,$email,$password) {
            $userVO = new view\User();
            $userVO->name = $name;
            $userVO->email = $email;
            
            //store into DB layer
            //password is not part of userVO
            $code = mysql\User::create($userVO,$password);
            return $code ;

        }

        function update($status) {
            
        }

        function logonUser($email, $password) {
            Util::isEmpty('Email', $email);
            Util::isEmpty('Password', $password);
            $data = mysql\User::logonUser($email, $password);
            return $data;
            
        }

    }

}
?>
