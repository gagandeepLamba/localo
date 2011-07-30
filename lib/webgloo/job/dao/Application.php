<?php

namespace webgloo\job\dao {

use webgloo\job\view as view;
use webgloo\job\mysql as mysql;

    class Application {
        
        function getRecords($organizationId,$openingId) {
            $rows = mysql\Application::getRecords($organizationId,$openingId);
            return $rows ;
        }

        function getRecordsOnUserId($userId) {
            $rows = mysql\Application::getRecordsOnUserId($userId);
            return $rows ;
        }

        function create($organizationId,
                $openingId, $userId, $forwarderEmail, $cvName,$cvTitle, $cvPhone,
                $cvEmail, $cvDescription,$cvCompany, $cvEducation,$cvLocation,$cvSkill) {

            $applicationVO = new view\Application();
            $applicationVO->organizationId = $organizationId;
            $applicationVO->openingId = $openingId;
            $applicationVO->userId = $userId;

            //contact information
            $applicationVO->forwarderEmail = $forwarderEmail;
            $applicationVO->cvName = $cvName;
            $applicationVO->cvPhone = $cvPhone;
            $applicationVO->cvEmail = $cvEmail;

            //job details
            $applicationVO->cvTitle = $cvTitle;
            $applicationVO->cvDescription = $cvDescription;
            $applicationVO->cvEducation = $cvEducation;
            $applicationVO->cvCompany = $cvCompany;
            $applicationVO->cvLocation = $cvLocation;
            $applicationVO->cvSkill = $cvSkill;


            //store into DB layer
            mysql\Application::create($applicationVO);
        }

        function update($status) {

        }

    }

}
?>
