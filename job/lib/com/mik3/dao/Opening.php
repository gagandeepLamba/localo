<?php

//some comments

namespace com\mik3\dao {

    use com\mik3\view as view;
    use com\mik3\mysql as mysql;
    use com\indigloo\common\Util ;
    
    class Opening {
        
        function checkNull($row) {
            //sanity check - cannot send applications for closed/expired openings
            if (is_null($row)) {
                trigger_error("No table row in database for this opening", E_USER_ERROR);
            }
        }

        function checkActive($row) {
            $interval = Util::secondsInDBTimeFromNow($row['expire_on']);
            if ($interval <= 0 || ($row['status'] != 'A')) {
                trigger_error("Job opening is not active or has expired", E_USER_ERROR);
            }
        }

        function checkApplicationCount($count) {
            if ($count >= 2) {
                trigger_error("You have already sent two applications for this opening", E_USER_ERROR);
            }
        }
        
        function getRecordOnId($openingId) {
            $row = mysql\Opening::getRecordOnId($openingId);
            return $row ;
        }

        function getEditRecordOnId($organizationId,$openingId){
            $row = mysql\Opening::getEditRecordOnId($organizationId,$openingId);
            return $row ;
        }
        
        function getRecordsOnOrgId($organizationId,$filter) {
            $rows = mysql\Opening::getRecordsOnOrgId($organizationId,$filter);
            return $rows ;
        }

        //@todo - getAllRecords should accept filters
        function getAllRecords() {
            $rows = mysql\Opening::getAllRecords();
            return $rows ;
        }
        
        function create(
                $organizationId,
                $organizationName,
                $createdBy,
                $title,
                $description,
                $skill,
                $bounty,
                $location,
                $expireOn,
                $minExperience,
                $maxExperience) {
            
            $openingVO = new view\Opening();
            $openingVO->title = $title;
            $openingVO->description = $description;
            $openingVO->bounty = $bounty;
			//create new opening with status 'A'
            $openingVO->status = 'A';
            $openingVO->organizationId = $organizationId;
            $openingVO->organizationName = $organizationName;
            $openingVO->skill = $skill;
            $openingVO->createdBy = $createdBy;
            $openingVO->location = $location;
            $openingVO->expireOn = $expireOn;
            $openingVO->minExperience = $minExperience ;
            $openingVO->maxExperience = $maxExperience ;

            //store into DB layer
            mysql\Opening::create($openingVO);

        }

        function update(
                $organizationId,
                $openingId,
                $title,
                $description,
                $skill,
                $bounty,
                $location,
                $minExperience,
                $maxExperience) {

            $openingVO->uuid = $openingId;
            $openingVO->organizationId = $organizationId;
            $openingVO->title = $title;
            $openingVO->description = $description;

            $openingVO->skill = $skill;
            $openingVO->bounty = $bounty;
            $openingVO->location = $location;
            
            $openingVO->minExperience = $minExperience ;
            $openingVO->maxExperience = $maxExperience ;

            //store into DB layer
            mysql\Opening::update($openingId, $openingVO);
        }

        function updateStatus($organizationId, $openingId,$status) {
            //store into DB layer
            mysql\Opening::updateStatus($organizationId, $openingId,$status);
        }

        function extendLife($organizationId, $openingId,$days) {
            //store into DB layer
            mysql\Opening::extendLife($organizationId, $openingId,$days);
        }


    }

}
?>
