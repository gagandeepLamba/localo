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
        
        static function add($postId,$mediaVO) {

            $mysqli = MySQL\Connection::getInstance()->getHandle();
            $code = MySQL\Connection::ACK_OK;
            $mediaId = NULL ;
            
            $sql1 = " insert into news_media(post_id,bucket,original_name, stored_name, " ;
            $sql1 .= " size,mime, original_height, original_width,created_on) ";
            $sql1 .= " values(?,?,?,?,?,?,?,?,now()) ";

            $dbCode = MySQL\Connection::ACK_OK;
            $stmt1 = $mysqli->prepare($sql1);
            
            if ($stmt1) {
                $stmt1->bind_param("isssisii",
                        $postId,
                        $mediaVO->bucket,
                        $mediaVO->originalName,
                        $mediaVO->storeName,
                        $mediaVO->size,
                        $mediaVO->mime,
                        $mediaVO->height,
                        $mediaVO->width);
                        

                $stmt1->execute();

                if ($mysqli->affected_rows != 1) {
                    $dbCode = MySQL\Error::handle(self::MODULE_NAME, $stmt1);
                }
                $stmt1->close();
            } else {
                $dbCode = MySQL\Error::handle(self::MODULE_NAME, $mysqli);
            }
            
            if($dbCode == MySQL\Connection::ACK_OK) {
                $mediaId = MySQL\Connection::getInstance()->getLastInsertId();
                $sql2 = " update news_post set media_json =? where id = ? " ;
                $stmt2 = $mysqli->prepare($sql2);
                
                if ($stmt2) {
                    $mediaVOJson = json_encode($mediaVO);
                    $stmt2->bind_param("si",$mediaVOJson,$postId);
                    $stmt2->execute();

                    if ($mysqli->affected_rows != 1) {
                        $dbCode = MySQL\Error::handle(self::MODULE_NAME, $stmt2);
                    }
                    $stmt2->close();
                } else {
                    $dbCode = MySQL\Error::handle(self::MODULE_NAME, $mysqli);
                }
            }
            
            return $mediaId;
        }

    }

}
?>
