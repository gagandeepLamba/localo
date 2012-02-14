<?php

namespace com\indigloo\sc\dao {

    
    use \com\indigloo\Util as Util ;
    use \com\indigloo\sc\mysql as mysql;
     
    class User {

		function getOnId($userId) {
			$rows = mysql\User::getOnId($userId);
			return $rows ;
		}
		
        function update($userId,$firstName,$lastName) {
            $code = mysql\User::update($userId,$firstName,$lastName);
            return $code ;
        }
        
        
    }

}
?>
