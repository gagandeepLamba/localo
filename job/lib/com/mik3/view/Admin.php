<?php

namespace com\mik3\view {

    class Admin {

        //unique ID for this user
        public $uuid;
        public $name;
        public $email;
        public $phone;
        public $organizationName;
        public $title;
        public $organizationId;

        //create one from DB Row
        function create($row) {
            $admin = new Admin();

            $admin->title = $row['title'];
            $admin->uuid = $row['id'];
            $admin->name = $row['name'];
            $admin->organizationName = $row['organization_name'];
            $admin->email = $row['email'];
            $admin->phone = $row['phone'];
            $admin->organizationId = $row['org_id'];

            return $admin;
        }

    }

}
?>
