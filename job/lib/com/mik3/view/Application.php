<?php

namespace com\mik3\view {

    class Application {

        //unique ID for this application
        public $uuid;
        public $userId;
        public $openingId;
        public $organizationId;
        //contact information
        //the user who sent this resume
        public $forwarderEmail;
        public $cvName;
        public $cvPhone;
        public $cvEmail;
        public $cvTitle;
        public $cvDescription;
        public $cvCompany;
        public $cvEducation;
        public $cvLocation;
        public $cvSkill;
        public $createdOn;
        // screening | interviews | offer | closed etc.
        public $stage;
        //review | dupilcate | rejected
        public $status;

        public $cvLinkedInPage;
        public $cvExperienceInYear;
        public $cvExperienceInMonth  ;
        
        //create one from DB Row
        function create($row) {
            $application = new Application();

            $application->uuid = $row['id'];
            $application->organizationId = $row['org_id'];
            $application->userId = $row['user_id'];
            $application->openingId = $row['opening_id'];

            $application->forwarderEmail = $row['forwarder_email'];
            $application->cvName = $row['cv_name'];
            $application->cvEmail = $row['cv_email'];
            $application->cvPhone = $row['cv_phone'];

            $application->cvTitle = $row['forwarder_email'];
            $application->cvDescription = $row['cv_description'];
            $application->cvCompany = $row['cv_company'];
            $application->cvEducation = $row['cv_education'];
            $application->cvLocation = $row['cv_location'];
            $application->cvSkill = $row['cv_skill'];

            $application->createdOn = $row['created_on'];
            $application->stage = $row['stage'];
            $application->status = $row['status'];

            $application->cvLinkedInPage = $row['cv_linkedin_page'];
            $application->cvExperienceInYear = $row['cv_experience_year'];
            $application->cvExperienceInMonth = $row['cv_experience_month'];

            return $application;
        }

    }

}
?>
