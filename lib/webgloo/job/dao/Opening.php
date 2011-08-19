<?php

//some comments

namespace webgloo\job\dao {

    use webgloo\job\view as view;
    use webgloo\job\mysql as mysql;

    class Opening {
        
        function getRecordOnId($openingId) {
            $row = mysql\Opening::getRecordOnId($openingId);
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
        
        function create($organizationId,$organizationName,$createdBy,$title, $description,$skill, $bounty,$location,$expireOn) {
            $openingVO = new view\Opening();
            $openingVO->title = $title;
            $openingVO->description = $description;
            $openingVO->bounty = $bounty;
            //$openingVO->status = 'OPEN';
            $openingVO->organizationId = $organizationId;
            $openingVO->organizationName = $organizationName;
            $openingVO->skill = $skill;
            $openingVO->createdBy = $createdBy;
            $openingVO->location = $location;
            $openingVO->expireOn = $expireOn;

            //store into DB layer
            mysql\Opening::create($openingVO);
        }

        function update($openingId, $title, $description, $bounty, $status) {
            $openingId = $mysqli->real_escape_string($openingId);
            $openingVO = new view\Opening();
            $openingVO->title = $title;
            $openingVO->description = $description;
            $openingVO->bounty = $bounty;
            $openingVO->status = $status;

            //store into DB layer
            mysql\Opening::update($openingId, $openingVO);
        }

    }

}
?>
