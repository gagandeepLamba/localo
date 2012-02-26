<?php

namespace com\indigloo\sc\html {

    use com\indigloo\Template as Template;
    use com\indigloo\sc\view\Media as MediaView ;
    use com\indigloo\Util as Util ;
    
    class User {
        
		private static function getPrivateProfile($userDBRow) {
		    $html = NULL ;
			$view = new \stdClass;
			$template = $_SERVER['APP_WEB_DIR'].'/fragments/user/profile/private.tmpl' ;
			
			
			$view->name = $userDBRow['first_name']. ' '.$userDBRow['last_name'];
			$view->createdOn = Util::formatDBTime($userDBRow['created_on']);
			$view->email = $userDBRow['email'];
			
			$html = Template::render($template,$view);
			
            return $html ;
	

		}

		public static function getPublicProfile($userDBRow) {
			return 'public' ;

		}

        static function getProfile($login,$userDBRow) {
		    $html = NULL ;
          	//private view needs owner
			if(!is_null($login) && ($login->id == $userDBRow['login_id'])) {
				$html = self::getPrivateProfile($userDBRow);
			} else {
				$html = self::getPublicProfile($userDBRow);

			}
			return $html ;
		  			
        }
		
    }
    
}

?>
