<?php

namespace com\indigloo\news\mysql {

    use com\indigloo\mysql as MySQL;

    class Media {
        
        const MODULE_NAME = 'com\indigloo\news\mysql\Media';
        
        static function getMediaOnPostId($postId) {
            $mysqli = MySQL\Connection::getInstance()->getHandle();
            $postId = $mysqli->real_escape_string($postId);

            $sql = " select * from news_media where post_id = ".$postId ;
            
            $rows = MySQL\Helper::fetchRows($mysqli, $sql);
            return $rows;
        }
        
        static function deleteOnId($mediaId) {
            $mysqli = MySQL\Connection::getInstance()->getHandle();
            $mediaId = $mysqli->real_escape_string($mediaId);
            
            
            $sql = " delete from news_media where id = ? ";
            MySQL\Helper::executeSQL($mysqli,$sql);
            
            $stmt = $mysqli->prepare($sql);
            if($stmt) {
                $stmt->bind_param("i",$mediaId);
                $stmt->execute();
                if($mysqli->affected_rows != 1)  {
                    MySQL\Error::handle(self::MODULE_NAME, $stmt);
                }
                
                $stmt->close();
            } else {
                MySQL\Error::handle(self::MODULE_NAME, $mysqli);
            }
            
        }
        
        static function add($mediaVO) {

            $mysqli = MySQL\Connection::getInstance()->getHandle();
            $code = MySQL\Connection::ACK_OK;
            $mediaId = NULL ;
            
            $sql = " insert into news_media(bucket,original_name, stored_name, " ;
            $sql .= " size,mime, original_height, original_width,created_on) ";
            $sql .= " values(?,?,?,?,?,?,?,now()) ";

            $dbCode = MySQL\Connection::ACK_OK;
            $stmt = $mysqli->prepare($sql);
            
            if ($stmt) {
                $stmt->bind_param("sssisii",
                        $mediaVO->bucket,
                        $mediaVO->originalName,
                        $mediaVO->storeName,
                        $mediaVO->size,
                        $mediaVO->mime,
                        $mediaVO->height,
                        $mediaVO->width);
                        

                $stmt->execute();

                if ($mysqli->affected_rows != 1) {
                    $dbCode = MySQL\Error::handle(self::MODULE_NAME, $stmt);
                }
                $stmt->close();
            } else {
                $dbCode = MySQL\Error::handle(self::MODULE_NAME, $mysqli);
                
            }
            
            if($dbCode == MySQL\Connection::ACK_OK) {
                $mediaId = MySQL\Connection::getInstance()->getLastInsertId();
            }
            
            return $mediaId;
        }

    }

}
?>
