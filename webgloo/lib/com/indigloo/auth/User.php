<?php

namespace com\indigloo\auth {
    
    use \com\indigloo\Util as Util;
    use \com\indigloo\mysql as MySQL;
    use \com\indigloo\auth\view\User as UserVO ;
    
    /**
     *
     * table structure used with this class
     * ======================================
     *  id 
        user_name ,
        password ,
        first_name ,
        last_name ,
        email ,
        is_staff int default 0 ,
        is_admin int default 0,
        is_active int not null default 1,
        salt ,
        login_on TIMESTAMP,
        created_on TIMESTAMP,
        updated_on TIMESTAMP
        =======================================
     *
     */
    class User {

        /**
         * for valid username/password combo
         * set the user details in session and return success code
         * for invalid username/password
         * return error code 
         * 
         * 
         */
       
        const MODULE_NAME = 'com\indigloo\auth\User';
        
        static function createView($row) {
            $user = new UserVO();
            
            $user->email = $row['email'];
            $user->firstName  =$row['first_name'];
            $user->lastName = $row['last_name'];
            $user->userName = $row['user_name'] ;
            
            return $user ;
        }
        
        static function login($tableName,$userName,$password) {
            
            $code = -1 ;
            if(empty($tableName)) {
                trigger_error("User Table name is not supplied",E_USER_ERROR);
                exit(1);
            }
            
            $mysqli = MySQL\Connection::getInstance()->getHandle();
            
            $password = trim($password);
            $userName = trim($userName);
            
            // change empty password - for time resistant attacks
            if (empty($password)) {
                $password = "123456789000000000";
            }

            $sql = " select * from {table} where is_active = 1 and user_name = '".$userName. "' " ;
            $sql = str_replace("{table}", $tableName, $sql);
            
            $row = MySQL\Helper::fetchRow($mysqli, $sql);
            
            if (!empty($row)) {
                
                $dbSalt = $row['salt'];
                $dbPassword = $row['password'];
                // compute the digest using form password and db Salt
                $message = $password.$dbSalt;
                $computedDigest = sha1($message);
                
                $outcome = strcmp($dbPassword, $computedDigest);
                
                //good password
                //set userdata in session
                if ($outcome == 0) {
                    $randomToken = Util::getBase36GUID();
                    $_SESSION['LOGON_TOKEN'] = $randomToken;
                    $_SESSION['LOGON_USER_DATA'] = $row;
                    $code = 1 ;
                }
            }
            
            return array('code' => $code);
        }
        
        function isStaff() {
            $flag = false ;
            if (isset($_SESSION) && isset($_SESSION['LOGON_TOKEN'])) {
                $userDBRow = $_SESSION['LOGON_USER_DATA'];
                $flag = ($userDBRow['is_staff'] == 1) ? true : false ;
            }
            
            return $flag;
        }

        function isAdmin() {
            $flag = false ;
            if (isset($_SESSION) && isset($_SESSION['LOGON_TOKEN'])) {
                $userDBRow = $_SESSION['LOGON_USER_DATA'];
                $flag = ($userDBRow['is_admin'] == 1) ? true : false ;
            }
            
            return $flag;
        }
        
        function isAuthenticated() {
            $flag = false ;
            if (isset($_SESSION) && isset($_SESSION['LOGON_TOKEN'])) {
                $flag = true ;
            }
            
            return $flag ;
        
        }
        
        static function getLoggedInUser() {
            $user = NULL ;
            if (isset($_SESSION) && isset($_SESSION['LOGON_TOKEN'])) {
                $userDBRow = $_SESSION['LOGON_USER_DATA'];
                $user =  UserVO::create($userDBRow);
                
            } else {
                trigger_error('logon session does not exists', E_USER_ERROR);
            }
            
            return $user ;
            
        }
         
        static function create($tableName,$firstName,$lastName,$userName,$email,$password) {
            
            if(empty($tableName)) {
                trigger_error("User Table name is not supplied",E_USER_ERROR);
                exit(1);
            }
            
            $mysqli = MySQL\Connection::getInstance()->getHandle();

            // use random salt + login and password
            // to create SHA-1 digest
            $salt = substr(md5(uniqid(rand(), true)), 0, 8);
            
            $password = trim($password);
            $userName = trim($userName);
            
            $message = $password.$salt;
            $digest = sha1($message);
            
            $sql = " insert into {table} (first_name, last_name, user_name,email,password,salt,created_on,is_staff) ";
            $sql .= " values(?,?,?,?,?,?,now(),0) ";
            $sql = str_replace("{table}", $tableName,$sql);
            

            $dbCode = MySQL\Connection::ACK_OK;

            //store computed password and random salt
            $stmt = $mysqli->prepare($sql);
            if ($stmt) {
                $stmt->bind_param("ssssss",
                        $firstName,
                        $lastName,
                        $userName,
                        $email,
                        $digest,
                        $salt);

                $stmt->execute();

                if ($mysqli->affected_rows != 1) {
                    $dbCode = MySQL\Error::handle(self::MODULE_NAME, $stmt);
                }
                $stmt->close();
            } else {
                $dbCode = MySQL\Error::handle(self::MODULE_NAME, $mysqli);
            }

            return array('code' => $dbCode);
        }
        
        
    }

}
?>
