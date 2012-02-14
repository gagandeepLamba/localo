<?php

namespace com\indigloo\sc\mysql {

    use \com\indigloo\mysql as MySQL;
    use \com\indigloo\Util as Util ;
    
    class Answer {
        
        const MODULE_NAME = 'com\indigloo\sc\mysql\Answer';

		static function getOnQuestionId($questionId) {
			$mysqli = MySQL\Connection::getInstance()->getHandle();
			$questionId = $mysqli->real_escape_string($questionId);
			
            $sql = " select * from sc_answer where question_id = ".$questionId ;
            $rows = MySQL\Helper::fetchRows($mysqli, $sql);
            return $rows;
		}
		
		static function getLatestOnUserEmail($email) {
			$mysqli = MySQL\Connection::getInstance()->getHandle();
			$email = $mysqli->real_escape_string($email);
			
			$sql = " select * from sc_answer where user_email = '".$email. "' " ;
			$sql .= " order by id desc LIMIT 5 " ;
			
			$rows = MySQL\Helper::fetchRows($mysqli, $sql);
            return $rows;
		
		}
		
        static function create($questionId,
								$answer,
								$userEmail,
								$userName) {

            $mysqli = MySQL\Connection::getInstance()->getHandle();
            $sql = " insert into sc_answer(question_id,answer,user_email,user_name, created_on) " ;
            $sql .= " values(?,?,?,?,now()) ";

            $code = MySQL\Connection::ACK_OK;
            $stmt = $mysqli->prepare($sql);
            
            if ($stmt) {
                $stmt->bind_param("isss",
								$questionId,
								$answer,
								$userEmail,
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
	}
}
?>
