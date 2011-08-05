<?php

namespace webgloo\job\html\template {

    use webgloo\common\html\template\Flexy as Flexy ;
    use webgloo\job\view as view ;

    class Application {
        
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

        static function getUserDetail($row,$action=false) {
            $flexy = Flexy::getInstance();
            $flexy->compile('/application/user/detail.tmpl');
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

            $view->cvDescription = substr($row['cv_description'],0,160);
            $view->cvDescription .= ' ...';
            $view->action = $action ;

            $view->openingId = $row['opening_id'] ;
            $view->applicationId = $row['id'] ;

            $html = $flexy->bufferedOutputObject ($view);
            return $html ;

        }

         static function getUserSummary($row) {
            $flexy = Flexy::getInstance();
            $flexy->compile('/application/user/summary.tmpl');
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
            $html = $flexy->bufferedOutputObject ($view);
            return $html ;

        }


    }

}
?>
