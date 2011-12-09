<?php 
namespace com\indigloo\auth\view {


    class User {
        
        public $firstName;
        public $lastName;
        public $userName ;
        public $email ;
        
        static function create($row) {
            $user = new User();
            $user->firstName = $row['first_name'] ;
            $user->lastName = '' ;
            $user->userName = $row['user_name'];
            $user->email = $row['email'];
            
        }
    }
}
    
?>