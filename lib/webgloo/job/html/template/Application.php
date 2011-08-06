<?php

namespace webgloo\job\html\template {

    use webgloo\common\html\template\Flexy as Flexy ;
    use webgloo\job\view as view ;

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

            $view->cvDescription = substr($row['cv_description'],0,160);
            $view->cvDescription .= ' ...';
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
            $view->createdOn = $row['created_on'];
            $view->createdBy = $row['created_by'];

            $view->title = $row['title'];
            $view->openingDescription = $row['opening_description'];
            $view->skill = $row['opening_skill'];


            $view->cvName = $row['cv_name'];
            $view->cvEmail = $row['cv_email'];
            $view->cvPhone = $row['cv_phone'];

            $view->cvEducation = $row['cv_education'];
            $view->cvLocation = $row['cv_location'];
            $view->cvCompany = $row['cv_company'];
            $view->cvSkill = $row['cv_skill'];

            $view->cvDescription = substr($row['cv_description'],0,160);
            $view->cvDescription .= ' ...';
            

            $view->openingId = $row['opening_id'] ;
            $view->applicationId = $row['id'] ;

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
            //shorten the description for summary?
            //@todo pull directly from DB?
            $view->cvDescription = substr($view->cvDescription,0,160);
            $view->cvDescription .= ' ...';
            $html = $flexy->bufferedOutputObject ($view);
            return $html ;

        }

      
        
    }

}
?>
