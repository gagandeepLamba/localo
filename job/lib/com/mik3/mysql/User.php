<?php

namespace com\mik3\mysql {

    use com\indigloo\common\mysql as MySQL;

    class User {
        const MODULE_NAME = 'com\mik3\mysql\User';

        static function getRecords() {
            $mysqli = MySQL\Connection::getInstance()->getHandle();
            $sql = " select * from job_user";
            $rows = MySQL\Helper::fetchRows($mysqli, $sql);
            return $rows;
        }

        static function logonUser($email, $password) {

            $data = array('code' => -1 ,'payload' => NULL );
            $mysqli = MySQL\Connection::getInstance()->getHandle();
            $email = $mysqli->real_escape_string($email);
            $password = $mysqli->real_escape_string($password);

            // empty password - time resistant attacks
            if (empty($password)) {
                $password = "123456789000000000";
            }

            $sql = " select * from job_user where email ='" . $email . "'";
            $row = MySQL\Helper::fetchRow($mysqli, $sql);

            //no result case - email does not exist
            if (!empty($row)) {
                //examine what is coming back
                $dbSalt = $row['salt'];
                $dbPassword = $row['password'];
                // compute the digest using form Password and db Salt
                $message = $password . $dbSalt;
                $computedDigest = sha1($message);
                $outcome = strcmp($dbPassword, $computedDigest);
                //good password
                if ($outcome == 0) {
                    $data = array('code' => 1, 'payload' => $row);
                    
                } 
            }
            
            return $data ;
        }

        static function create($userVO,$password) {

            $mysqli = MySQL\Connection::getInstance()->getHandle();

            // get random salt
            //create SHA-1 digest from login and password
            $salt = substr(md5(uniqid(rand(), true)), 0, 8);
            $message = $password . $salt;
            $digest = sha1($message);
            
            $sql = " insert into job_user(name,email,password,salt,created_on) ";
            $sql .= " values(?,?,?,?,now()) ";

            $dbCode = MySQL\Connection::ACK_OK;

            //store computed password and random salt
            $stmt = $mysqli->prepare($sql);
            if ($stmt) {
                $stmt->bind_param("ssss",
                        $userVO->name,
                        $userVO->email,
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

            return $dbCode;
        }

    }

}
?>
