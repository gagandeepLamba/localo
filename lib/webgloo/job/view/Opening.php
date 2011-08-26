<?php

//some comments

namespace webgloo\job\view {

    class Opening {
        
        //unique ID for this opening
        public $uuid;
        public $title;
        public $organizationId;
        public $organizationName;
        public $skill;
        public $createdOn;
        public $createdBy ;
        public $description;
        public $bounty;
        public $location ;
        public $expireOn ;

        //open/suspended/closed
        //default status is open
        public $status;
        public $minExperience ;
        public $maxExperience ;

        function __construct() {
            
        }

        //create one from DB Row
        function create($row) {
            $opening = new Opening();
            $opening->title = $row['title'];
            $opening->uuid = $row['id'];
            $opening->organizationId = $row['org_id'];
            
            $opening->organizationName = $row['organization_name'];
            $opening->createdOn = $row['created_on'];
            $opening->description = $row['description'];
            $opening->skill = $row['skill'];
            
            $opening->bounty = $row['bounty'];
            $opening->createdBy = $row['created_by'];
            $opening->location = $row['location'];
            $opening->applicationCount = $row['application_count'];
            $opening->expireOn = $row['expire_on'];
            $opening->minExperience = $row['min_experience'] ;
            $opening->maxExperience = $row['max_experience'] ;

            return $opening ;
        }

    }

}
?>
