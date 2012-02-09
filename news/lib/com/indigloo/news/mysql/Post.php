<?php

namespace com\indigloo\news\mysql {

    use \com\indigloo\mysql as MySQL;
    use \com\indigloo\Util as Util ;
    use \com\indigloo\Configuration as Config ;
    use \com\indigloo\Logger as Logger ;
    
    class Post {
        
        const MODULE_NAME = 'com\indigloo\news\mysql\Post';

        static function getRecordOnId($postId) {
            $mysqli = MySQL\Connection::getInstance()->getHandle();
            $postId = $mysqli->real_escape_string($postId);

            $sql = " select * from news_post where id = ".$postId ;
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
        
        static function getLatestRecords($pageSize){
            $mysqli = MySQL\Connection::getInstance()->getHandle();
            
            $sql = " select post.* from news_post post" ;
            $sql .= " order by post.id DESC LIMIT " .$pageSize;
            
            if(Config::getInstance()->is_debug()) {
                Logger::getInstance()->debug("sql => $sql \n");
            }
            
            $rows = MySQL\Helper::fetchRows($mysqli, $sql);
            return $rows;
        
        }
        
        static function getLatestLinks($pageSize){
            $mysqli = MySQL\Connection::getInstance()->getHandle();
            
            $sql = " select link.* from news_link link " ;
            $sql .= " order by link.id DESC LIMIT " .$pageSize;
            
            
            if(Config::getInstance()->is_debug()) {
                Logger::getInstance()->debug("sql => $sql \n");
            }
            
            $rows = MySQL\Helper::fetchRows($mysqli, $sql);
            return $rows;
        
        }
        
        static function getRecords($start,$direction,$pageSize){
            $mysqli = MySQL\Connection::getInstance()->getHandle();
            
            // primary key id is an excellent proxy for created_on column
            // latest posts has max(id) and appears on top
            // so AFTER (NEXT) means id < latest post id
            
            $predicate = '' ;
            
            if($direction == 'after') {
                $predicate = " where post.id < ".$start ;
                $predicate .= " order by post.id DESC LIMIT " .$pageSize;
            } else if($direction == 'before'){
                $predicate = " where post.id > ".$start ;
                $predicate .= " order by post.id ASC LIMIT " .$pageSize;
            } else {
                trigger_error("Unknow sort direction in query", E_USER_ERROR);
            }
            
            $sql = " select post.* from news_post post " ;
            $sql .= $predicate ;
            
            if(Config::getInstance()->is_debug()) {
                Logger::getInstance()->debug("sql => $sql \n");
            }
            
            $rows = MySQL\Helper::fetchRows($mysqli, $sql);
            
            //reverse rows for 'before' direction
            if($direction == 'before') {
                $results = array_reverse($rows) ;
                return $results ;
            }
            
            return $rows;
            
        }
        
        static function getLinks($index,$direction,$pageSize){
            $mysqli = MySQL\Connection::getInstance()->getHandle();
            $predicate = '' ;
            
            if($direction == 'after') {
                $predicate = " where link.id < ".$index ;
                $predicate .= " order by link.id DESC LIMIT " .$pageSize;
            } else if($direction == 'before'){
                $predicate = " where link.id > ".$index ;
                $predicate .= " order by link.id ASC LIMIT " .$pageSize;
            } else {
                trigger_error("Unknow sort direction in query", E_USER_ERROR);
            }
            
            $sql = " select link.* from news_link link " ;
            $sql .= $predicate ;
            
            if(Config::getInstance()->is_debug()) {
                Logger::getInstance()->debug("sql => $sql \n");
            }
            
            $rows = MySQL\Helper::fetchRows($mysqli, $sql);
            
            //reverse rows for 'before' direction
            if($direction == 'before') {
                $results = array_reverse($rows) ;
                return $results ;
            }
            
            return $rows;
            
        }
        
        
        static function create($title,$seoTitle,$summary,$description,
                               $linksJson,$imagesJson,$userId,$userName) {

            $mysqli = MySQL\Connection::getInstance()->getHandle();
            $sql = " insert into news_post(short_id,title,seo_title,summary,description, " ;
            $sql .= " links_json,images_json,created_on, user_id, user_name) ";
            $sql .= " values(?,?,?,?,?,?,?,now(),?,?) ";

            $dbCode = MySQL\Connection::ACK_OK;
            $stmt = $mysqli->prepare($sql);
            $lastInsertId = NULL ;
            $shortId = Util::getRandomString(8);
            
            
            if ($stmt) {
                $stmt->bind_param("sssssssss",
                        $shortId,
                        $title,
                        $seoTitle,
                        $summary,
                        $description,
                        $linksJson,
                        $imagesJson,
                        $userId,
                        $userName);
                      
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
            
            return array('code' => $dbCode ,
                         'lastInsertId' => $lastInsertId,
                         'seoTitle' => $seoTitle,
                          'shortId' => $shortId) ;
            
        }

         static function createLink($author,$link,$description) {

            $mysqli = MySQL\Connection::getInstance()->getHandle();
            $sql = " insert into news_link(author,link,description,created_on) ";
            $sql .= " values(?,?,?,now()) ";

            $dbCode = MySQL\Connection::ACK_OK;
            $stmt = $mysqli->prepare($sql);
            
            if ($stmt) {
                $stmt->bind_param("sss",
                        $author,
                        $link,
                        $description);
                        

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
         
        static function update($postId,$title,$seoTitle,$summary,$description,$linksJson,$imagesJson) {
            
            $mysqli = MySQL\Connection::getInstance()->getHandle();
            $sql = "  update news_post set title = ? , seo_title = ? , summary = ? ,description =? ," ;
            $sql .= "  links_json = ? , images_json = ? , updated_on = now() where id = ? ";
            

            $dbCode = MySQL\Connection::ACK_OK;
            $stmt = $mysqli->prepare($sql);
            
            if ($stmt) {
                $stmt->bind_param("ssssssi",
                        $title,
                        $seoTitle,
                        $summary,
                        $description,
                        $linksJson,
                        $imagesJson,
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
        
        static function getRecordsCount() {
            
            $mysqli = MySQL\Connection::getInstance()->getHandle();
            $sql = " select count(id) as count from news_post " ;  
            $row = MySQL\Helper::fetchRow($mysqli, $sql);
            return $row;
        }
        
        static function getLinksCount() {
            
            $mysqli = MySQL\Connection::getInstance()->getHandle();
            
            $sql = " select count(id) as count from news_link " ;  
            $row = MySQL\Helper::fetchRow($mysqli, $sql);
            return $row;
        }
    }

}
?>
