<?php

namespace com\mik3\dao {

    use com\mik3\view as view;
    use com\mik3\mysql as mysql;
    use com\indigloo\Util as Util ;
    
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
