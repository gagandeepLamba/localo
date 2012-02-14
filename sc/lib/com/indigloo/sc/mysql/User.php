<?php

namespace com\indigloo\sc\mysql {

    use \com\indigloo\mysql as MySQL;
    use \com\indigloo\Util as Util ;
    
    class User {
        
        const MODULE_NAME = 'com\indigloo\sc\mysql\User';

		static function getOnId($userId) {
			$mysqli = MySQL\Connection::getInstance()->getHandle();
			$userId = $mysqli->real_escape_string($userId);
			
            $sql = " select * from sc_user where id = ".$userId ;
            $row = MySQL\Helper::fetchRow($mysqli, $sql);
            return $row;
		}
		
	}
}
?>
