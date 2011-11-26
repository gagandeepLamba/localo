<?php

namespace com\indigloo\auth {
    
    use \com\indigloo\Util as Util;
    use \com\mik3\dao as Dao;

    class FormAuthentication {

        static function logonAdmin($email, $password) {
            
             //see if password match
            $adminDao = new Dao\Admin();
            $data = $adminDao->logonAdmin($email, $password);

            if ($data['code'] < 0) {
                //error condition
                return -1;
            } else {
                //logon success
                //start of a new session
                $randomToken = Util::getBase36GUID();
                $_SESSION['LOGON_TOKEN'] = $randomToken;
                $_SESSION['LOGON_ROLE'] = Util::base64Encrypt('CUSTOMER_ADMIN');
                $row = $data['payload'];

                if (empty($row)) {
                    trigger_error('No data found for Admin :: '.$email, E_USER_ERROR);
                }

                $adminVO = new \com\mik3\view\Admin();
                $admin = $adminVO->create($row);
                $_SESSION['LOGON_USER_DATA'] = $admin;
            }

            return 1;

        }

        static function logonUser($email, $password) {
            //see if password match
            $userDao = new Dao\User();
            $data = $userDao->logonUser($email, $password);

            if ($data['code'] < 0) {
                //error condition
                return -1;
            } else {
                //logon success
                //start of a new session
                //@todo - clear the last session
                $randomToken = Util::getBase36GUID();
                $_SESSION['LOGON_TOKEN'] = $randomToken;
                $_SESSION['LOGON_ROLE'] = Util::base64Encrypt('USER');
                $row = $data['payload'];
                
                if (empty($row)) {
                    trigger_error('No data found for user :: '.$email, E_USER_ERROR);
                }
                
                $userVO = new \com\mik3\view\User();
                $user = $userVO->create($row);
                $_SESSION['LOGON_USER_DATA'] = $user;
            }

            return 1;
        }

        //region - query methods - will assume a session exists
        // these methods throw exception

        static function getLoggedInUser() {
            //logon related data
            if (self::tryUserRole()) {
                //return userVO
                $data = $_SESSION['LOGON_USER_DATA'];
                if (empty($data)) {
                    trigger_error('User session does not have any data', E_USER_ERROR);
                }
                return $data;
            } else {
                trigger_error('User session does not exists', E_USER_ERROR);
            }
        }

        static function getLoggedInAdmin() {
            //logon related data
            if (self::tryAdminRole()) {
                //return userVO
                $data = $_SESSION['LOGON_USER_DATA'];
                if (empty($data)) {
                    trigger_error('User session does not have any data', E_USER_ERROR);
                }
                return $data;
            } else {
                trigger_error('User session does not exists', E_USER_ERROR);
            }
        }

        //region try query methods - do not raise exception for these methods

        static function tryUserRole() {
            //check if we have a session going
            $flag = false;
            if (isset($_SESSION) && isset($_SESSION['LOGON_TOKEN'])) {
                $role = $_SESSION['LOGON_ROLE'];
                $role = Util::base64Decrypt($role);
                if (strcmp($role, 'USER') == 0) {
                    $flag = true;
                }
            }
            return $flag;
        }

        static function tryAdminRole() {
            $flag = false;
            if (isset($_SESSION) && isset($_SESSION['LOGON_TOKEN'])) {
                $role = $_SESSION['LOGON_ROLE'];
                $role = Util::base64Decrypt($role);
                if (strcmp($role, 'CUSTOMER_ADMIN') == 0) {
                    $flag = true;
                }
            }
            return $flag;
        }

    }

}
?>
