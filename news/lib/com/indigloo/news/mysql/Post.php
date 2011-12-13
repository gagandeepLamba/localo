<?php

namespace com\indigloo\news\mysql {

    use \com\indigloo\mysql as MySQL;
    use \com\indigloo\Util as Util ;
    
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
        
        static function getRecordOnShortId($shortId) {
            $mysqli = MySQL\Connection::getInstance()->getHandle();
            $shortId = $mysqli->real_escape_string($shortId);

            $sql = " select * from news_post where short_id = '".$shortId. "' " ;
            $row = MySQL\Helper::fetchRow($mysqli, $sql);
            return $row;
        }
        
        static function getRecords() {
            $mysqli = MySQL\Connection::getInstance()->getHandle();
            
            $sql = " select * from news_post " ;  
            $rows = MySQL\Helper::fetchRows($mysqli, $sql);
            return $rows;
        }
        
        static function getRecordsWithMedia($pageNo,$pageSize){
            $mysqli = MySQL\Connection::getInstance()->getHandle();
             
            $sql = " select post.*, media.bucket, media.id as media_id," ;
            $sql .= " media.stored_name,media.original_name, media.original_height,media.original_width " ;
            $sql .= " from news_post post LEFT  JOIN news_media media ON post.s_media_id = media.id ";
            $sql .= " order by post.created_on DESC " ;
            
            $offset = 0 + ($pageNo - 1 ) * $pageSize;
            $sql = $sql." LIMIT  " .$offset. "," .$pageSize;

            $rows = MySQL\Helper::fetchRows($mysqli, $sql);
            return $rows;
            
        }
        
        static function getRecordsWithMediaCount() {
            
            $mysqli = MySQL\Connection::getInstance()->getHandle();
            
            $sql = " select count(id) as count from news_post " ;  
            $row = MySQL\Helper::fetchRow($mysqli, $sql);
            return $row;
        }
        
        static function create($title,$seoTitle,$summary,$markdown,$html) {

            $mysqli = MySQL\Connection::getInstance()->getHandle();
            $sql = " insert into news_post(short_id,title,seo_title,summary,markdown,description,created_on) ";
            $sql .= " values(?,?,?,?,?,?,now()) ";

            $dbCode = MySQL\Connection::ACK_OK;
            $stmt = $mysqli->prepare($sql);
            $lastInsertId = NULL ;
            $shortId = Util::getRandomString(8);
            
            
            if ($stmt) {
                $stmt->bind_param("ssssss",
                        $shortId,
                        $title,
                        $seoTitle,
                        $summary,
                        $markdown,
                        $html);
                      
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

         static function createLink($title,$summary,$link) {

            $mysqli = MySQL\Connection::getInstance()->getHandle();
            $sql = " insert into news_link(title,summary,link,created_on) ";
            $sql .= " values(?,?,?,now()) ";

            $dbCode = MySQL\Connection::ACK_OK;
            $stmt = $mysqli->prepare($sql);
            
            if ($stmt) {
                $stmt->bind_param("sss",
                        $title,
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
        
        static function update($postId,$title,$seoTitle,$summary,$markdown,$html) {

            $mysqli = MySQL\Connection::getInstance()->getHandle();
            $sql = "  update news_post set title = ? , seo_title = ? , summary = ? , markdown = ? ,description =? ," ;
            $sql .= " updated_on = now() where id = ? ";
            

            $dbCode = MySQL\Connection::ACK_OK;
            $stmt = $mysqli->prepare($sql);
            
            if ($stmt) {
                $stmt->bind_param("sssssi",
                        $title,
                        $seoTitle,
                        $summary,
                        $markdown,
                        $html,
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
