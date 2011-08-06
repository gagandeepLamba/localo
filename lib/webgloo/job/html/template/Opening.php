<?php

namespace webgloo\job\html\template {

    use webgloo\common\html\template\Flexy as Flexy ;
    use webgloo\job\view as view ;

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
            
            $view->description = substr($view->description,0,340);
            $view->description .= ' ...';
            $html = $flexy->bufferedOutputObject ($view);
            return $html ;
        }

        //used on new application page
        static function getUserSummary($row) {
            $flexy = Flexy::getInstance();
            $flexy->compile('/opening/user/summary.tmpl');
            $opening = new view\Opening();
            $view = $opening->create($row);
            //shorten the description for summary?
            //@todo pull directly from DB?
            $view->description = substr($view->description,0,340);
            $view->description .= ' ...';
            $html = $flexy->bufferedOutputObject ($view);
            return $html ;
        }

        //used on company opening list page
        // and on company applications list page
        static function getOrganizationSummary($row) {
            $flexy = Flexy::getInstance();
            $flexy->compile('/opening/org/summary.tmpl');
            $opening = new view\Opening();
            $view = $opening->create($row);
            //shorten the description for summary?
            $view->description = substr($view->description,0,340);
            $view->description .= ' ...';
            
            //do we want to show application links?
            if($view->applicationCount > 0 ) {
                $view->showApplication = true ;
            } else {
                $view->showApplication = false ;
            }

            $html = $flexy->bufferedOutputObject ($view);
            return $html ;
        }

        //used on POST CV page
        //action controls whether or not to show
        // post cv and share action links
        // ajax opening detail is also using this method
        static function getUserDetail($row,$action=false) {
            $flexy = Flexy::getInstance();
            $flexy->compile('/opening/user/detail.tmpl');
            $opening = new view\Opening();
            $view = $opening->create($row);
            $view->action = $action;
            
            $html = $flexy->bufferedOutputObject ($view);
            return $html ;
        }
        
    }

}
?>
