<?php

namespace webgloo\job\dao {

    use webgloo\job\view as view;
    use webgloo\job\mysql as mysql;
    use webgloo\common\Util ;

    class Application {
        
        function getRecords($organizationId,$openingId) {
            $rows = mysql\Application::getRecords($organizationId,$openingId);
            return $rows ;
        }

        function getDocuments($applicationId) {
            $rows = mysql\Application::getDocuments($applicationId);
            return $rows ;
        }

        function getRecordsOnUserAndOpeningId($userId,$openingId) {
            $rows = mysql\Application::getRecordsOnUserAndOpeningId($userId,$openingId);
            return $rows ;
        }

         function getCountOnUserAndOpeningId($userId,$openingId) {
            Util::isEmpty('userId', $userId);
            Util::isEmpty('openingId', $openingId);
            
            $row = mysql\Application::getCountOnUserAndOpeningId($userId,$openingId);
            $count = 0 ;
            if(!empty($row)){
                $count = $row['total_count'];
            }

            return $count;
        }

        function getRecordsOnUserId($userId) {
            $rows = mysql\Application::getRecordsOnUserId($userId);
            return $rows ;
        }

        function getRecordOnId($applicationId) {
            $row = mysql\Application::getRecordOnId($applicationId);
            return $row ;
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
            $data = mysql\Application::create($applicationVO);
            return $data ;
        }

        function update($status) {

        }

    }

}
?>
