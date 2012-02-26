<?php

namespace com\indigloo\sc\mysql {

    use \com\indigloo\mysql as MySQL;
    use \com\indigloo\Util as Util ;
    use \com\indigloo\Configuration as Config ;
    
    class Answer {
        
        const MODULE_NAME = 'com\indigloo\sc\mysql\Answer';
		//DB columns for filters
		const LOGIN_COLUMN = "login_id" ;

		static function getOnQuestionId($questionId) {
			$mysqli = MySQL\Connection::getInstance()->getHandle();
			$questionId = $mysqli->real_escape_string($questionId);
			
            $sql = " select * from sc_answer where question_id = ".$questionId ;
            $rows = MySQL\Helper::fetchRows($mysqli, $sql);
            return $rows;
		}
		
		static function getOnId($answerId) {
			$mysqli = MySQL\Connection::getInstance()->getHandle();
			$answerId = $mysqli->real_escape_string($answerId);
			
            $sql = " select * from sc_answer where id = ".$answerId ;
            $row = MySQL\Helper::fetchRow($mysqli, $sql);
            return $row;
		}
		
		static function getLatest($count,$dbfilter) {
			$mysqli = MySQL\Connection::getInstance()->getHandle();

			$condition = '' ;
			if(array_key_exists(self::LOGIN_COLUMN,$dbfilter)) {
				$condition = " where login_id = ".$dbfilter[self::LOGIN_COLUMN] ;
			}

			$sql = " select * from sc_answer ".$condition." order by id desc LIMIT ".$count ;
			$rows = MySQL\Helper::fetchRows($mysqli, $sql);
            return $rows;
		
		}
		
		static function getTotalCount($dbfilter) {
			$mysqli = MySQL\Connection::getInstance()->getHandle();

			$condition = '';
			if(array_key_exists(self::LOGIN_COLUMN,$dbfilter)) {
				$condition = " where login_id = ".$dbfilter[self::LOGIN_COLUMN] ;
			}

            $sql = " select count(id) as count from sc_answer ".$condition ;
            $row = MySQL\Helper::fetchRow($mysqli, $sql);
            return $row;
		}

		static function getPaged($start,$direction,$count,$dbfilter) {
			$mysqli = MySQL\Connection::getInstance()->getHandle();
            
            $sql = " select a.* from sc_answer a " ;
            $predicate = '' ;
			$condition = '' ;

			if(array_key_exists(self::LOGIN_COLUMN,$dbfilter)) {
				$condition = " and login_id = ".$dbfilter[self::LOGIN_COLUMN] ;
			}

            if($direction == 'after') {
                $predicate = " where a.id < ".$start ;
                $predicate .= $condition ;
                $predicate .= " order by a.id DESC LIMIT " .$count;

            } else if($direction == 'before'){
                $predicate = " where a.id > ".$start ;
                $predicate .= $condition ;
                $predicate .= " order by a.id ASC LIMIT " .$count;
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

        static function create($questionId,
								$answer,
								$loginId,
								$userName) {

            $mysqli = MySQL\Connection::getInstance()->getHandle();
            $sql = " insert into sc_answer(question_id,answer,login_id,user_name, created_on) " ;
            $sql .= " values(?,?,?,?,now()) ";

            $code = MySQL\Connection::ACK_OK;
            $stmt = $mysqli->prepare($sql);
            
            if ($stmt) {
                $stmt->bind_param("isis",
								$questionId,
								$answer,
								$loginId,
								$userName);
                
                      
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
		
		static function update($answerId,$answer) {
			
			$code = MySQL\Connection::ACK_OK ;
			$mysqli = MySQL\Connection::getInstance()->getHandle();
			$sql = "update sc_answer set answer = ? where id = ? " ;
			
			
			$stmt = $mysqli->prepare($sql);
            
            if ($stmt) {
                $stmt->bind_param("si",$answer,$answerId) ;
                $stmt->execute();
                $stmt->close();
				
            } else {
                $code = MySQL\Error::handle(self::MODULE_NAME, $mysqli);
            }
			
			return $code ;
			
		}
	}
}
?>
