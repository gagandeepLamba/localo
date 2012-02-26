<?php

namespace com\indigloo\sc\dao {

    
    use \com\indigloo\Util as Util ;
    use \com\indigloo\sc\mysql as mysql;
     
    class User {

		function getOnId($userId) {
			$row = mysql\User::getOnId($userId);
			return $row ;
		}

		function getOnLoginId($provider,$loginId) {
			//@todo - select tables based on provider
			$table = NULL ;
			switch($provider) {
				case '3mik' :
					$table = 'sc_user' ;
					break ;
				default:
					trigger_error("Unknown provider",E_USER_ERROR);
					break;
			}
			
			$row = mysql\User::getOnLoginId($loginId);
			return $row ;
		}
		
        function update($userId,$firstName,$lastName) {
            $code = mysql\User::update($userId,$firstName,$lastName);
            return $code ;
        }
        
        
    }

}
?>
