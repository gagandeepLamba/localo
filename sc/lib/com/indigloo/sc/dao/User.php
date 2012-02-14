<?php

namespace com\indigloo\sc\dao {

    
    use \com\indigloo\Util as Util ;
    use \com\indigloo\sc\mysql as mysql;
    use \com\indigloo\seo\StringUtil as SeoStringUtil ;
    
    class User {

		function getOnId($userId) {
			$rows = mysql\User::getOnId($userId);
			return $rows ;
		}
		
    }

}
?>
