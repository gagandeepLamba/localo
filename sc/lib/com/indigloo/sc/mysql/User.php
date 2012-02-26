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

		static function getOnLoginId($loginId) {
			$mysqli = MySQL\Connection::getInstance()->getHandle();
			$loginId = $mysqli->real_escape_string($loginId);
			
            $sql = " select * from sc_user where login_id = ".$loginId ;
            $row = MySQL\Helper::fetchRow($mysqli, $sql);
            return $row;
		}
		

		static function update($userId,$firstName,$lastName) {
			$code = MySQL\Connection::ACK_OK;

			$mysqli = MySQL\Connection::getInstance()->getHandle();
			$sql = " update sc_user set first_name = ? , last_name = ? where id = ?" ;
			
			$stmt = $mysqli->prepare($sql);
        
			if($stmt) {
				$stmt->bind_param("ssi",
						$firstName,
						$lastName,
						$userId);
	
				$stmt->execute();
				$stmt->close();
				
			} else {
				$code = Gloo_MySQL_Error::handle(self::MODULE_NAME, $mysqli);
			}

			return $code ;
		}
		
	}
}
?>
