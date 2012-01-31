<?php

namespace com\indigloo\sc\dao {

    
    use com\indigloo\Util as Util ;
    use com\indigloo\sc\mysql as mysql;
    
    class User {

        function create($name,$email,$location,$password) {
           $data = mysql\User::create($name,$email,$location,$password);
           return $data;
            
        }
        
        function login($email,$password) {
            
            $row = mysql\User::getPassword($email);
            $code = -1 ;
            
            if(!empty($row)) {
                
                if($row['password'] == $password) {
                    //start session
                    $randomToken = Util::getBase36GUID();
                    $_SESSION['LOGON_TOKEN'] = $randomToken;
                    $_SESSION['LOGON_USER_DATA'] = $row;
                    $code = 1 ; 
                }
            }
            
           return $code ;
        }
        
        function isAuthenticated() {
            $flag = false ;
            if (isset($_SESSION) && isset($_SESSION['LOGON_TOKEN'])) {
                $flag = true ;
            }
            
            return $flag ;
        
        }
        
        function getLoggedInUser() {
            $row = NULL ;
            if (isset($_SESSION) && isset($_SESSION['LOGON_TOKEN'])) {
                $row = $_SESSION['LOGON_USER_DATA'];
                
            } else {
                trigger_error('logon session does not exists', E_USER_ERROR);
            }
            
            return $row ;
            
        }
        
    }

}

?>
