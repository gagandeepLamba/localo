<?php

namespace com\indigloo\sc\auth {
    
    use \com\indigloo\Util as Util;
    use \com\indigloo\Configuration as Config ;
    use \com\indigloo\Logger as Logger ;
	use \com\indigloo\auth\User as WebglooUser ;
    
    class Login {

		const NAME = "SC_USER_NAME";
		const LOGIN_ID = "SC_LOGIN_ID";
		const PROVIDER = "SC_USER_PROVIDER";
		const TOKEN = "TOKEN" ;

		static function startMikSession() {
            if (isset($_SESSION) && isset($_SESSION[WebglooUser::USER_TOKEN])) {
				$row = $_SESSION[WebglooUser::USER_DATA];

				if(empty($row) || empty($row['user_name']) || empty($row['login_id'])) {
					trigger_error("Missing user data in 3mik session", E_USER_ERROR);
				}

				$_SESSION[self::NAME] = $row['user_name'];
				$_SESSION[self::LOGIN_ID] = $row['login_id'];
				$_SESSION[self::PROVIDER] = "3mik";
				$_SESSION[self::TOKEN] = Util::getBase36GUID();

			} else {
				trigger_error("No 3mik user data found in session", E_USER_ERROR);
			}
	
		}

		static function getLoginInSession() {
            
            if (isset($_SESSION) && isset($_SESSION[self::TOKEN])) {
				$login = new \com\indigloo\sc\auth\view\Login();

				$login->name = $_SESSION[self::NAME] ;
				$login->provider = $_SESSION[self::PROVIDER] ;
				$login->id = $_SESSION[self::LOGIN_ID] ;
				return $login ;
                
            } else {
                trigger_error('logon session does not exists', E_USER_ERROR);
            }
            
        }

		static function tryLoginInSession() {
            
            if (isset($_SESSION) && isset($_SESSION[self::TOKEN])) {
				$login = new \com\indigloo\sc\auth\view\Login();

				$login->name = $_SESSION[self::NAME] ;
				$login->provider = $_SESSION[self::PROVIDER] ;
				$login->id = $_SESSION[self::LOGIN_ID] ;
				return $login ;
                
            } else {
				return NULL;
            }
            
        }

		function isValid() {
            $flag = false ;
            if (isset($_SESSION) && isset($_SESSION[self::TOKEN])) {
                $flag = true ;
            }
            
            return $flag ;
        }

	

		

	}
}
