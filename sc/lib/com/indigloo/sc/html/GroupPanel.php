<?php

namespace com\indigloo\sc\html {

    use com\indigloo\Util as Util ;
    use com\indigloo\util\StringUtil as StringUtil ;
    use com\indigloo\Template as Template;
    
    class GroupPanel {

        static function render($strGroups){

            if(is_null($strGroups)) {
                $strGroups = '' ;
            }

            $records = array();

            // system defined categories
            $categories = array("handicrafts",
                                "baby-and-kids",
                                "clothes",
                                "fashion",
                                "home-and-interior",
                                "cool-items"); 

            $ugroups = explode(",",$strGroups);

            foreach($ugroups as $value) {
                if(empty($value)) { continue ; }
                $value = trim($value);
                //get display strings
                $display =  StringUtil::convertKeyToName($value);
                $records[] = array("value" => $value, "display" => $display ,"checked" => "checked") ;

            }

			$view = new \stdClass;
			$template = '/fragments/ui/group/panel.tmpl' ;

            foreach ($categories as $value) {
                if(in_array($value,$ugroups)) { continue ; }

                $display =  StringUtil::convertKeyToName($value);
                $records[] = array("value" => $value, "display" => $display, "checked" => "") ;
            }
            
            $view->records  = $records ;
            $view->total = sizeof($records);
            $view->step = 3 ;
            //3 visible panels -> 2 + step + step 
            $view->numVisible = (2*$view->step) + 2 ;
            $view->numVisible = ($view->numVisible > $view->total) ? $view->total : $view->numVisible;

            $view->moreLink = false ;

            if($view->total > $view->numVisible){
                //render more link
                $view->moreLink = true ;
            }



			$html = Template::render($template,$view);
            return $html ;

        }

    }
    
}

?>
