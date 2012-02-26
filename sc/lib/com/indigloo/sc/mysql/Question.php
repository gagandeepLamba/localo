<?php

namespace com\indigloo\sc\mysql {

    use \com\indigloo\mysql as MySQL;
    use \com\indigloo\Util as Util ;
    use \com\indigloo\Configuration as Config ;
    
    class Question {
        
        const MODULE_NAME = 'com\indigloo\sc\mysql\Question';

		//DB columns for filters
		const LOGIN_COLUMN = "login_id" ;

		static function getOnId($questionId) {
			$mysqli = MySQL\Connection::getInstance()->getHandle();
			$questionId = $mysqli->real_escape_string($questionId);
			
            $sql = " select * from sc_question where id = ".$questionId ;
            $row = MySQL\Helper::fetchRow($mysqli, $sql);
            return $row;
		}
		
		static function getLatest($count,$dbfilter) {
			
			$mysqli = MySQL\Connection::getInstance()->getHandle();

			$condition = '' ;
			if(array_key_exists(self::LOGIN_COLUMN,$dbfilter)) {
				$condition = " where login_id = ".$dbfilter[self::LOGIN_COLUMN];
			}

			$sql = " select * from sc_question ".$condition." order by id desc LIMIT ".$count ;
			
            $rows = MySQL\Helper::fetchRows($mysqli, $sql);
            return $rows;
			
		}

		static function getTotalCount($dbfilter) {
			$mysqli = MySQL\Connection::getInstance()->getHandle();

			$condition = '';
			if(array_key_exists(self::LOGIN_COLUMN,$dbfilter)) {
				$condition = " where login_id = ".$dbfilter[self::LOGIN_COLUMN];
			}

            $sql = " select count(id) as count from sc_question  ".$condition ;
            $row = MySQL\Helper::fetchRow($mysqli, $sql);
            return $row;

		}

		static function getPaged($start,$direction,$count,$dbfilter) {
			$mysqli = MySQL\Connection::getInstance()->getHandle();
            
            // primary key id is an excellent proxy for created_on column
            // latest posts has max(id) and appears on top
            // so AFTER (NEXT) means id < latest post id
            
            $sql = " select q.* from sc_question q " ;
            $predicate = '' ;
			$condition = '' ;

			if(array_key_exists(self::LOGIN_COLUMN,$dbfilter)) {
				$condition = " and login_id = ".$dbfilter[self::LOGIN_COLUMN];
			}

            if($direction == 'after') {
                $predicate = " where q.id < ".$start ;
                $predicate .= $condition ;
                $predicate .= " order by q.id DESC LIMIT " .$count;

            } else if($direction == 'before'){
                $predicate = " where q.id > ".$start ;
                $predicate .= $condition ;
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
							   $loginId,
							   $userName,
                               $linksJson,
                               $imagesJson) {

			
			
            $mysqli = MySQL\Connection::getInstance()->getHandle();
            $sql = " insert into sc_question(title,seo_title,description,category_code,location,tags, " ;
            $sql .= " login_id,user_name,links_json,images_json,created_on) ";
            $sql .= " values(?,?,?,?,?,?,?,?,?,?,now()) ";

            $code = MySQL\Connection::ACK_OK;
            $stmt = $mysqli->prepare($sql);
            
            if ($stmt) {
                $stmt->bind_param("ssssssisss",
                        $title,
                        $seoTitle,
                        $description,
                        $category,
                        $location,
						$tags,
						$loginId,
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
