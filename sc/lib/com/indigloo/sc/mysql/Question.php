<?php

namespace com\indigloo\sc\mysql {

    use \com\indigloo\mysql as MySQL;
    use \com\indigloo\Util as Util ;
    use \com\indigloo\Configuration as Config ;
    
    class Question {
        
        const MODULE_NAME = 'com\indigloo\sc\mysql\Question';

		static function getOnId($questionId) {
			$mysqli = MySQL\Connection::getInstance()->getHandle();
			$questionId = $mysqli->real_escape_string($questionId);
			
            $sql = " select * from sc_question where id = ".$questionId ;
            $row = MySQL\Helper::fetchRow($mysqli, $sql);
            return $row;
		}
		
		static function getLatestOnUserEmail($email) {
			$mysqli = MySQL\Connection::getInstance()->getHandle();
			$email = $mysqli->real_escape_string($email);
			
			$sql = " select * from sc_question where user_email = '".$email. "' " ;
			$sql .= " order by id desc LIMIT 5 " ;
			
			$rows = MySQL\Helper::fetchRows($mysqli, $sql);
            return $rows;
		
		}
		
		static function getAllOnUserEmail($email) {
			$mysqli = MySQL\Connection::getInstance()->getHandle();
			$email = $mysqli->real_escape_string($email);
			
			$sql = " select * from sc_question where user_email = '".$email. "' " ;
			$sql .= " order by id desc" ;
			
			$rows = MySQL\Helper::fetchRows($mysqli, $sql);
            return $rows;
		}
		
		
		static function getLatest($count) {
			
			$mysqli = MySQL\Connection::getInstance()->getHandle();
            $sql = " select * from sc_question order by id desc LIMIT ".$count ;
			
            $rows = MySQL\Helper::fetchRows($mysqli, $sql);
            return $rows;
			
		}

		static function getTotalCount() {
			$mysqli = MySQL\Connection::getInstance()->getHandle();
            $sql = " select count(id) as count from sc_question " ;  
            $row = MySQL\Helper::fetchRow($mysqli, $sql);
            return $row;

		}

		static function getPaged($start,$direction,$count) {
			$mysqli = MySQL\Connection::getInstance()->getHandle();
            
            // primary key id is an excellent proxy for created_on column
            // latest posts has max(id) and appears on top
            // so AFTER (NEXT) means id < latest post id
            
            $sql = " select q.* from sc_question q " ;
            $predicate = '' ;
            
            if($direction == 'after') {
                $predicate = " where q.id < ".$start ;
                $predicate .= " order by q.id DESC LIMIT " .$count;

            } else if($direction == 'before'){
                $predicate = " where q.id > ".$start ;
                $predicate .= " order by q.id ASC LIMIT " .$count;
            } else {
                trigger_error("Unknow sort direction in query", E_USER_ERROR);
            }
            
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

		static function update($questionId,
						       $title,
							   $seoTitle,
                               $description,
                               $category,
                               $location,
                               $tags,
                               $linksJson,
                               $imagesJson)
		
		{
			
			$mysqli = MySQL\Connection::getInstance()->getHandle();
            $sql = " update sc_question set title=?, seo_title=?, description=?, category_code =?, " ;
			$sql .= " location=?, tags=?, links_json=?, images_json=? where id = ? " ;
			
			
            $code = MySQL\Connection::ACK_OK;
            $stmt = $mysqli->prepare($sql);
            
            
            if ($stmt) {
                $stmt->bind_param("ssssssssi",
                        $title,
                        $seoTitle,
                        $description,
                        $category,
                        $location,
                        $tags,
                        $linksJson,
                        $imagesJson,
						$questionId);
                
                      
                $stmt->execute();

                if ($mysqli->affected_rows != 1) {
                    $code = MySQL\Error::handle(self::MODULE_NAME, $stmt);
                }
                $stmt->close();
            } else {
                $code = MySQL\Error::handle(self::MODULE_NAME, $mysqli);
            }
            
            
            return $code ;
            
		}
		
        static function create($title,
                               $seoTitle,
                               $description,
                               $category,
                               $location,
                               $tags,
							   $userEmail,
							   $userName,
                               $linksJson,
                               $imagesJson) {

			
			
            $mysqli = MySQL\Connection::getInstance()->getHandle();
            $sql = " insert into sc_question(title,seo_title,description,category_code,location,tags, " ;
            $sql .= " user_email,user_name,links_json,images_json,created_on) ";
            $sql .= " values(?,?,?,?,?,?,?,?,?,?,now()) ";

            $code = MySQL\Connection::ACK_OK;
            $stmt = $mysqli->prepare($sql);
            
            if ($stmt) {
                $stmt->bind_param("ssssssssss",
                        $title,
                        $seoTitle,
                        $description,
                        $category,
                        $location,
						$tags,
						$userEmail,
						$userName,
                        $linksJson,
                        $imagesJson);
                
                      
                $stmt->execute();

                if ($mysqli->affected_rows != 1) {
                    $code = MySQL\Error::handle(self::MODULE_NAME, $stmt);
                }
                $stmt->close();
            } else {
                $code = MySQL\Error::handle(self::MODULE_NAME, $mysqli);
            }
			
			return $code ;
        }
	}
}
?>
