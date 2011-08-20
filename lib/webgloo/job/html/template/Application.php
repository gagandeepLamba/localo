<?php

namespace webgloo\job\html\template {

    use webgloo\common\html\template\Flexy as Flexy ;
    use webgloo\job\view as view ;
    use webgloo\common\Util ;
    
    class Application {

         //only application vanilla details
         // compnay information is clear from context
         // used in ajax page to fetch information
         static function getDetail($row) {
            $flexy = Flexy::getInstance();
            $flexy->compile('/application/vanilla/detail.tmpl');
            $view = new \stdClass;
            //create a view from table join
            //details of opening
            $view->organizationName = $row['organization_name'];
            $view->bounty = $row['bounty'];
            $view->createdOn = $row['created_on'];
            $view->title = $row['title'];

            $view->cvName = $row['cv_name'];
            $view->cvEmail = $row['cv_email'];
            $view->cvPhone = $row['cv_phone'];

            $view->cvEducation = $row['cv_education'];
            $view->cvLocation = $row['cv_location'];
            $view->cvCompany = $row['cv_company'];
            $view->cvSkill = $row['cv_skill'];

            $view->cvDescription = $row['cv_description'];
            
            $view->openingId = $row['opening_id'] ;
            $view->applicationId = $row['id'] ;

            $html = $flexy->bufferedOutputObject ($view);
            return $html ;

        }

        //get application vanilla summary
        static function getSummary($row,$optional) {
            $flexy = Flexy::getInstance();
            $flexy->compile('/application/vanilla/summary.tmpl');
            $view = new \stdClass;

            $view->createdOn = $row['created_on'];

            $view->cvName = $row['cv_name'];
            $view->cvEmail = $row['cv_email'];
            $view->cvPhone = $row['cv_phone'];

            $view->cvEducation = $row['cv_education'];
            $view->cvLocation = $row['cv_location'];
            $view->cvCompany = $row['cv_company'];
            $view->cvSkill = $row['cv_skill'];

            $view->cvDescription = $row['cv_description'];
            if (strlen($view->cvDescription) > 340) {
                $view->cvDescription = substr($view->cvDescription, 0, 340);
                $view->cvDescription .= ' ...';
            }


            $view->applicationId = $row['id'];

            foreach($optional as $key => $value) {
                //the joys of PHP
                // everything is a string!
                $view->$key = $value ;
            }
            $html = $flexy->bufferedOutputObject ($view);
            return $html ;

        }
        
        static function getUserSummary2($row,$optional) {
            $flexy = Flexy::getInstance();
            $flexy->compile('/application/user/summary2.tmpl');
            $view = new \stdClass;

            $view->createdOn = $row['created_on'];

            $view->cvName = $row['cv_name'];
            $view->cvEmail = $row['cv_email'];
            $view->cvPhone = $row['cv_phone'];

            $view->cvEducation = $row['cv_education'];
            $view->cvLocation = $row['cv_location'];
            $view->cvCompany = $row['cv_company'];

            if(empty($view->cvCompany)) {
                 $view->cvCompany = 'N/A' ;
            }
            
            $view->cvSkill = $row['cv_skill'];

            $view->cvDescription = $row['cv_description'];
            if (strlen($view->cvDescription) > 340) {
                $view->cvDescription = substr($view->cvDescription, 0, 340);
                $view->cvDescription .= ' ...';
            }

            $view->applicationId = $row['id'];

            foreach($optional as $key => $value) {
                //the joys of PHP
                // everything is a string!
                $view->$key = $value ;
            }
            $html = $flexy->bufferedOutputObject ($view);
            return $html ;

        } 



        //summary for user pages - with opening summary
         static function getUserSummary($row,$optional) {
            $flexy = Flexy::getInstance();
            $flexy->compile('/application/user/summary.tmpl');
            $view = new \stdClass;
            //create a view from table join
            //details of opening
            $view->organizationName = $row['organization_name'];
            $view->bounty = $row['bounty'];
            $view->expireOn = Util::formatDBTime($row['opp_expire_on']);
            
            $view->title = $row['opp_title'];
            $view->openingDescription = $row['opp_description'];
            $view->skill = $row['opp_skill'];


            $view->cvName = $row['cv_name'];
            $view->cvEmail = $row['cv_email'];
            $view->cvPhone = $row['cv_phone'];

            $view->cvEducation = $row['cv_education'];
            $view->cvLocation = $row['cv_location'];
            $view->cvCompany = $row['cv_company'];

            if(empty($view->cvCompany)) {
                 $view->cvCompany = 'N/A' ;
            }

            $view->cvSkill = $row['cv_skill'];

            $view->cvDescription = $row['cv_description'];
            if (strlen($view->cvDescription) > 340) {
                $view->cvDescription = substr($view->cvDescription, 0, 340);
                $view->cvDescription .= ' ...';
            }
            
            $view->cvPostedOn = $row['created_on'];


            $view->openingId = $row['opening_id'] ;
            $view->applicationId = $row['id'] ;
            $view->organizationId = $row['org_id'];
            
            foreach($optional as $key => $value) {
                // everything is a string!
                $view->$key = $value ;
            }
            
            $html = $flexy->bufferedOutputObject ($view);
            return $html ;

        }
        
         static function getOrganizationSummary($row) {
            $flexy = Flexy::getInstance();
            $flexy->compile('/application/org/summary.tmpl');
            $application = new view\Application();
            $view = $application->create($row);

            if(empty($view->cvCompany)) {
                 $view->cvCompany = 'N/A' ;
            }
            
            $view->descriptionClass = 'normal';

             if (strlen($view->cvDescription) > 340) {
                //we need to print a summary
                $view->summary = substr($view->cvDescription, 0, 340);
                $view->summary .= '...' ;
                $view->hasSummary = true ;
                //hide long descriptions on page load
                $view->descriptionClass = 'hide-me';
            }
            
            $html = $flexy->bufferedOutputObject ($view);
            return $html ;

        }

      
        
    }

}
?>
