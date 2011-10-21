<?php



namespace com\3mik\dao {

    use com\3mik\view as view ;
    use com\3mik\mysql as mysql ;
    
    class Organization {

        function checkNull($row) {
            if (is_null($row)) {
                trigger_error("No table row in database for this organization", E_USER_ERROR);
            }
        }

        function getRecordOnId($organizationId) {
            $row = mysql\Organization::getRecordOnId($organizationId);
            return $row;
        }

        function create($name, $email, $domain, $description) {
            $organizationVO = new view\Organization();
            $organizationVO->name = $name;
            $organizationVO->email = $email;
            $organizationVO->domain = $domain;
            $organizationVO->description = $description;
            //store into DB layer
            mysql\Organization::create($organizationVO);
        }

        function update($organizationId,$name,$website,$description) {
            //store into DB layer
            mysql\Organization::update($organizationId,$name,$website,$description);

        }

    }

}
?>
