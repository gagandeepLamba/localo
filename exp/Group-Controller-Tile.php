<?php
namespace com\indigloo\sc\controller{


	use \com\indigloo\Util as Util;
    use com\indigloo\Url;
	use \com\indigloo\Configuration as Config ;
  
	
    class Group {
        
        function process($params,$options) {
            
            if(is_null($params) || empty($params))
                trigger_error("Required params is null or empty", E_USER_ERROR);

			$slug = Util::getArrayKey($params,"name");
            //break hyphenated tokens into normal words for sphinx
            $token = \com\indigloo\util\StringUtil::convertKeyToName($slug);

            //get match on group slug
            $sphinx = new \com\indigloo\sc\search\SphinxQL();
            $ids = $sphinx->getPostIdsOnGroup($token);

            $template = $_SERVER['APP_WEB_DIR']. '/view/tiles.php';

            //page variables
            $pageTitle = NULL ;
            $pageHeader = NULL ;

            if(sizeof($ids) > 0 ) {
                $pageTitle = "Group - $token" ;
                $questionDao = new \com\indigloo\sc\dao\Question();
                $questionDBRows = $questionDao->getOnSearchIds($ids) ;

            } else {
                $pageTitle = "No Results for group $token" ;
            }

            $pageHeader = $pageTitle ;
            $pageBaseUrl = "/group/".$slug ;
            
            include($template); 
        }
    }
}
?>
