<?php

namespace com\indigloo\news\mysql {

    use com\indigloo\mysql as MySQL;

    class Post {
        
        const MODULE_NAME = 'com\indigloo\news\mysql\Post';

        static function getRecordOnId($postId) {
            $mysqli = MySQL\Connection::getInstance()->getHandle();
            $postId = $mysqli->real_escape_string($postId);

            $sql = " select * from news_post where id = ".$postId ;
            //$sql = str_replace("{postId}", $postId, $sql);
            
            $row = MySQL\Helper::fetchRow($mysqli, $sql);
            return $row;
        }
        
        static function getRecords() {
            $mysqli = MySQL\Connection::getInstance()->getHandle();
            
            $sql = " select * from news_post " ;  
            $rows = MySQL\Helper::fetchRows($mysqli, $sql);
            return $rows;
        }
        
        static function create($title,$summary,$description) {

            $mysqli = MySQL\Connection::getInstance()->getHandle();
            $sql = " insert into news_post(title,summary,description,created_on) ";
            $sql .= " values(?,?,?,now()) ";

            $dbCode = MySQL\Connection::ACK_OK;
            $stmt = $mysqli->prepare($sql);
            
            if ($stmt) {
                $stmt->bind_param("sss",
                        $title,
                        $summary,
                        $description);
                        

                $stmt->execute();

                if ($mysqli->affected_rows != 1) {
                    $dbCode = MySQL\Error::handle(self::MODULE_NAME, $stmt);
                }
                $stmt->close();
            } else {
                $dbCode = MySQL\Error::handle(self::MODULE_NAME, $mysqli);
            }
            
             //if no one has raised an error
            if($dbCode == MySQL\Connection::ACK_OK) {
                //get last insert id
                $lastInsertId = MySQL\Connection::getInstance()->getLastInsertId();
            }
            
            return array('code' => $dbCode , 'lastInsertId' => $lastInsertId ) ;
            
            
        }

    }

}
?>
