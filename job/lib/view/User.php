<?php

//some comments

namespace webgloo\job\view {

    class User {
        
        public $uuid ;
        public $name ;
        public $email ;
        
        //create one from DB Row
        function create($row) {
            $user = new User();
            $user->uuid = $row['id'];
            $user->name = $row['name'];
            $user->email = $row['email'];
            return $user ;
        }

    }

}
?>
