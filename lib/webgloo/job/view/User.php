<?php

//some comments

namespace webgloo\job\view {

    class User {
         //unique ID for this user
        public $uuid ;
        public $firstName ;
        public $lastName;
        public $email ;
        public $phone ;
        public $company ;
        public $title ;

        //create one from DB Row
        function create($row) {
            $user = new User();
            $user->title = $row['title'];
            $user->uuid = $row['id'];

            $user->firstName = $row['first_name'];
            $user->lastName = $row['last_name'];

            $user->email = $row['email'];
            $user->phone = $row['phone'];
            $user->company = $row['company'];
            
            return $user ;
        }

    }

}
?>
