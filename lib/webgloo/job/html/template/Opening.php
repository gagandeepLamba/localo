<?php

namespace webgloo\job\html\template {

    use webgloo\common\html\template\Flexy as Flexy ;
    use webgloo\job\view as view ;

    class Opening {

         static function getMainSummary($row) {
            $flexy = Flexy::getInstance();
            $flexy->compile('/opening/main/summary.tmpl');
            $opening = new view\Opening();
            $view = $opening->create($row);
            //shorten the description for summary?
            //@todo pull directly from DB?
            $view->description = substr($view->description,0,160);
            $view->description .= ' ...';
            $html = $flexy->bufferedOutputObject ($view);
            return $html ;
        }

        static function getUserSummary($row) {
            $flexy = Flexy::getInstance();
            $flexy->compile('/opening/user/summary.tmpl');
            $opening = new view\Opening();
            $view = $opening->create($row);
            //shorten the description for summary?
            //@todo pull directly from DB?
            $view->description = substr($view->description,0,160);
            $view->description .= ' ...';
            $html = $flexy->bufferedOutputObject ($view);
            return $html ;
        }

        static function getOrganizationSummary($row) {
            $flexy = Flexy::getInstance();
            $flexy->compile('/opening/org/summary.tmpl');
            $opening = new view\Opening();
            $view = $opening->create($row);
            //shorten the description for summary?
            //@todo pull directly from DB?
            $view->description = substr($view->description,0,160);
            $view->description .= ' ...';
            $html = $flexy->bufferedOutputObject ($view);
            return $html ;
        }

        
        static function getUserDetail($row) {

            $flexy = Flexy::getInstance();
            $flexy->compile('/opening/user/detail.tmpl');
            $opening = new view\Opening();
            $view = $opening->create($row);
            $html = $flexy->bufferedOutputObject ($view);
            return $html ;

        }

        static function getOrganizationDetail($row) {

            $flexy = Flexy::getInstance();
            $flexy->compile('/opening/org/detail.tmpl');
            $opening = new view\Opening();
            $view = $opening->create($row);
            $html = $flexy->bufferedOutputObject ($view);
            return $html ;

        }

    }

}
?>
