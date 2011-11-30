<?php

namespace com\indigloo\news\mysql {

    use com\indigloo\mysql as MySQL;

    class Post {
        
        const MODULE_NAME = 'com\indigloo\news\mysql\Post';

        static function getRecordOnId($postId) {
            $mysqli = MySQL\Connection::getInstance()->getHandle();
            $postId = $mysqli->real_escape_string($postId);

            $sql = " select * from news_post where id = ".$postId ;
            $row = MySQL\Helper::fetchRow($mysqli, $sql);
            return $row;
        }
        
        static function getMediaOnId($postId) {
            $mysqli = MySQL\Connection::getInstance()->getHandle();
            $postId = $mysqli->real_escape_string($postId);

            $sql = " select bucket,stored_name,original_name from news_media where post_id = ".$postId ;
            $rows = MySQL\Helper::fetchRows($mysqli, $sql);
            return $rows;
            
        }
        
        
        static function getRecordOnSeoTitle($seoTitle) {
            $mysqli = MySQL\Connection::getInstance()->getHandle();
            $seoTitle = $mysqli->real_escape_string($seoTitle);

            $sql = " select * from news_post where seo_title = '".$seoTitle. "' " ;
            $row = MySQL\Helper::fetchRow($mysqli, $sql);
            return $row;
        }
        
        static function getRecords() {
            $mysqli = MySQL\Connection::getInstance()->getHandle();
            
            $sql = " select * from news_post " ;  
            $rows = MySQL\Helper::fetchRows($mysqli, $sql);
            return $rows;
        }
        
        static function getRecordsWithMedia(){
            $mysqli = MySQL\Connection::getInstance()->getHandle();
             
            $sql = " select post.*, media.bucket, media.id as media_id," ;
            $sql .= " media.stored_name,media.original_name, media.original_height,media.original_width " ;
            $sql .= " from news_post post LEFT  JOIN news_media media ON post.s_media_id = media.id ";
            $sql .= " order by post.created_on " ;
            
            $rows = MySQL\Helper::fetchRows($mysqli, $sql);
            return $rows;
            
        }
        
        
        static function create($title,$seoTitle,$summary,$description) {

            $mysqli = MySQL\Connection::getInstance()->getHandle();
            $sql = " insert into news_post(title,seo_title,summary,description,created_on) ";
            $sql .= " values(?,?,?,?,now()) ";

            $dbCode = MySQL\Connection::ACK_OK;
            $stmt = $mysqli->prepare($sql);
            
            if ($stmt) {
                $stmt->bind_param("ssss",
                        $title,
                        $seoTitle,
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
            
            if($dbCode == MySQL\Connection::ACK_OK) {
                
                $lastInsertId = MySQL\Connection::getInstance()->getLastInsertId();
            }
            
            return array('code' => $dbCode , 'lastInsertId' => $lastInsertId ) ;
            
            
        }

         static function createLink($title,$seoTitle,$summary,$link) {

            $mysqli = MySQL\Connection::getInstance()->getHandle();
            $sql = " insert into news_post(title,seo_title,summary,link,created_on,is_link) ";
            $sql .= " values(?,?,?,?,now(),1) ";

            $dbCode = MySQL\Connection::ACK_OK;
            $stmt = $mysqli->prepare($sql);
            
            if ($stmt) {
                $stmt->bind_param("ssss",
                        $title,
                        $seoTitle,
                        $summary,
                        $link);
                        

                $stmt->execute();

                if ($mysqli->affected_rows != 1) {
                    $dbCode = MySQL\Error::handle(self::MODULE_NAME, $stmt);
                }
                $stmt->close();
            } else {
                $dbCode = MySQL\Error::handle(self::MODULE_NAME, $mysqli);
            }
            
            return array('code' => $dbCode) ;
        }
        
        static function update($postId,$title,$seoTitle,$summary,$description) {

            $mysqli = MySQL\Connection::getInstance()->getHandle();
            $sql = "  update news_post set title = ? , seo_title = ? , summary = ? , description =? ," ;
            $sql .= " updated_on = now() where id = ? ";
            

            $dbCode = MySQL\Connection::ACK_OK;
            $stmt = $mysqli->prepare($sql);
            
            if ($stmt) {
                $stmt->bind_param("ssssi",
                        $title,
                        $seoTitle,
                        $summary,
                        $description,
                        $postId);
                        

                $stmt->execute();

                if ($mysqli->affected_rows != 1) {
                    $dbCode = MySQL\Error::handle(self::MODULE_NAME, $stmt);
                }
                $stmt->close();
            } else {
                $dbCode = MySQL\Error::handle(self::MODULE_NAME, $mysqli);
            }
            
            return array('code' => $dbCode) ;
        }
        
        static function updateLink($postId,$title,$seoTitle,$summary,$link) {

            $mysqli = MySQL\Connection::getInstance()->getHandle();
            $sql = "  update news_post set title = ? , seo_title = ? , summary = ? , link = ? ," ;
            $sql .= " updated_on = now() where id = ? ";
            

            $dbCode = MySQL\Connection::ACK_OK;
            $stmt = $mysqli->prepare($sql);
            
            if ($stmt) {
                $stmt->bind_param("ssssi",
                        $title,
                        $seoTitle,
                        $summary,
                        $link,
                        $postId);
                        

                $stmt->execute();

                if ($mysqli->affected_rows != 1) {
                    $dbCode = MySQL\Error::handle(self::MODULE_NAME, $stmt);
                }
                $stmt->close();
            } else {
                $dbCode = MySQL\Error::handle(self::MODULE_NAME, $mysqli);
            }
            
            return array('code' => $dbCode) ;
        }
        
    }

}
?>
