<?php

namespace webgloo\job\html\template {

    use webgloo\common\html\template\Flexy as Flexy;
    use webgloo\job\view as view;
    use webgloo\common\Util;

    class Opening {

        //used on main site page
        static function getMainSummary($row) {
            $flexy = Flexy::getInstance();
            $flexy->compile('/opening/main/summary.tmpl');
            $opening = new view\Opening();
            $view = $opening->create($row);
            //shorten the description for summary?
            //php 5.3 substr will select at most 340 chars
            // so we should be fine.
            if (strlen($view->description) > 340) {
                $view->description = substr($view->description, 0, 340);
                $view->description .= ' ...';
            }

            //number of days left to expire
            //calculate interval in seconds for expire_on date from now
            $interval = Util::secondsInDBTimeFromNow($row['expire_on']);
            $view->lifeInDays = ($interval > 0) ? ceil($interval / (24 * 3600)) : 'N/A';
            //DD - Month - YYYY 
            $view->createdOn = Util::formatDBTime($row['created_on'], "%d %b %Y");
            $view->expireOn = Util::formatDBTime($row['expire_on'], "%d %b %Y");

            $html = $flexy->bufferedOutputObject($view);
            return $html;
        }

        //used on new application page
        static function getUserSummary($row) {
            $flexy = Flexy::getInstance();
            $flexy->compile('/opening/user/summary.tmpl');
            $opening = new view\Opening();
            $view = $opening->create($row);

            
            $view->description = substr($view->description, 0, 340);
            $view->description .= ' ...';
            $html = $flexy->bufferedOutputObject($view);
            return $html;
        }

        //used on company opening list page
        // and on company applications list page
        static function getOrganizationSummary($row) {
            $flexy = Flexy::getInstance();
            $flexy->compile('/opening/org/summary.tmpl');
            $opening = new view\Opening();
            $view = $opening->create($row);
            $view->descriptionClass = 'normal';
            
             if (strlen($view->description) > 340) {
                //we need to print a summary
                $view->summary = substr($view->description, 0, 340);
                $view->summary .= '...' ;
                $view->hasSummary = true ;
                //hide long descriptions on page load
                $view->descriptionClass = 'hide-me';
            }
            
            //number of days left to expire
            //calculate interval in seconds for expire_on date from now
            $interval = Util::secondsInDBTimeFromNow($row['expire_on']);
            $view->lifeInDays = ($interval > 0) ? ceil($interval / (24 * 3600)) : 'N/A';
            //DD - Month - YYYY
            $view->createdOn = Util::formatDBTime($row['created_on'], "%d %b %Y");
            $view->expireOn = Util::formatDBTime($row['expire_on'], "%d %b %Y");

            //do we want to show application links?
            if ($view->applicationCount > 0) {
                $view->showApplication = true;
            } else {
                $view->showApplication = false;
            }

            $html = $flexy->bufferedOutputObject($view);
            return $html;
        }

        static function getOrganizationSummary2($row){
            $flexy = Flexy::getInstance();
            $flexy->compile('/opening/org/summary2.tmpl');
            $opening = new view\Opening();
            $view = $opening->create($row);
            
            //number of days left to expire
            //calculate interval in seconds for expire_on date from now
            $interval = Util::secondsInDBTimeFromNow($row['expire_on']);
            $view->lifeInDays = ($interval > 0) ? ceil($interval / (24 * 3600)) : 'N/A';
            //DD - Month - YYYY
            $view->createdOn = Util::formatDBTime($row['created_on'], "%d %b %Y");
            $view->expireOn = Util::formatDBTime($row['expire_on'], "%d %b %Y");

            $html = $flexy->bufferedOutputObject($view);
            return $html;
        }
        
        //used on POST CV page
        //action controls whether or not to show
        // post cv and share action links
        // ajax opening detail is also using this method
        static function getUserDetail($row,$applicationCount,$action=false) {
            $flexy = Flexy::getInstance();
            $flexy->compile('/opening/user/detail.tmpl');
            $opening = new view\Opening();
            $view = $opening->create($row);
            $view->action = $action;

            //number of days left to expire
            //calculate interval in seconds for expire_on date from now
            $interval = Util::secondsInDBTimeFromNow($row['expire_on']);
            $view->lifeInDays = ($interval > 0) ? ceil($interval / (24 * 3600)) : 'N/A';
            //DD - Month - YYYY
            $view->createdOn = Util::formatDBTime($row['created_on'], "%d %b %Y");
            $view->expireOn = Util::formatDBTime($row['expire_on'], "%d %b %Y");
            //@todo - populate organization description
            $view->organizationDescription = 'abcd';

            //turn off post CV when application count >= 2
            $view->showPostCVAction = ($applicationCount >= 2 ) ? false : true ;
            
            $html = $flexy->bufferedOutputObject($view);
            return $html;
        }

    }

}
?>
