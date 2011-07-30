<?php

//some comments

namespace webgloo\job\view {

    class Admin {
         //unique ID for this user
        public $uuid ;
        public $firstName ;
        public $lastName;
        public $email ;
        public $phone ;
        public $company ;
        public $title ;
        public $organizationId ;

        //create one from DB Row
        function create($row) {
            $admin = new Admin();
            $admin->title = $row['title'];
            $admin->uuid = $row['id'];

            $admin->firstName = $row['first_name'];
            $admin->lastName = $row['last_name'];

            $admin->email = $row['email'];
            $admin->phone = $row['phone'];
            $admin->company = $row['company'];
            $admin->organizationId = $row['org_id'];

            return $admin ;
        }

    }

}
?>
