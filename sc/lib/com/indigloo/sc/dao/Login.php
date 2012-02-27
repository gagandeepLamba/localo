<?php
namespace com\indigloo\sc\dao {

	use \com\indigloo\Util as Util ;
    use \com\indigloo\sc\mysql as mysql;

	class Login {

		function getOnId($loginId) {
			$row = mysql\Login::getOnId($loginId);
			return $row ;


		}

		function create($provider,$name){
			$loginId = mysql\Login::create($provider,$name);
			return $loginId ;
		}

	}
}
?>
