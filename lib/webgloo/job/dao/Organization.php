<?php



namespace webgloo\job\dao {

use webgloo\job\view as view ;
use webgloo\job\mysql as mysql ;

    class Organization {

         function getRecords() {
            $rows = mysql\Organization::getRecords();
            return $rows ;
        }
        
        function create($name, $email, $domain, $description) {
            $organizationVO = new view\Organization() ;
            $organizationVO->name = $name ;
            $organizationVO->email = $email ;
            $organizationVO->domain = $domain ;
            $organizationVO->description = $description ;
            //store into DB layer
            mysql\Organization::create($organizationVO);
            
        }

        
        function update($status) {

        }

    }

}
?>
