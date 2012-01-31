<?php

namespace com\indigloo\sc\mysql {

    use com\indigloo\mysql as MySQL;

    class User {
        
        const MODULE_NAME = 'com\indigloo\sc\mysql\User';
        
        static function getPassword($email) {
            
            $mysqli = MySQL\Connection::getInstance()->getHandle();
            $sql = " select * from sc_user where email = '".$email. "' " ;
            
            $row = MySQL\Helper::fetchRow($mysqli, $sql);
            return $row ;
            
        }
        
        static function create($name,$email,$location,$password) {

            $mysqli = MySQL\Connection::getInstance()->getHandle();
            $code = MySQL\Connection::ACK_OK;
            $mediaId = NULL ;
            
            $sql = " insert into sc_user(name,email,location,password,created_on) " ;
            $sql .= " values(?,?,?,?,now()) ";
        
            $stmt = $mysqli->prepare($sql);
            
            if ($stmt) {
                
                $stmt->bind_param("ssss",$name,$email,$location,$password);
                $stmt->execute();

                if ($mysqli->affected_rows != 1) {
                    $dbCode = MySQL\Error::handle(self::MODULE_NAME, $stmt);
                }
                $stmt->close();
            } else {
                $code = MySQL\Error::handle(self::MODULE_NAME, $mysqli);
                
            }
            
            return $code;
        }

    }

}
?>
