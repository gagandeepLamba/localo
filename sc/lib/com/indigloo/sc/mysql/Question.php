<?php

namespace com\indigloo\sc\mysql {

    use \com\indigloo\mysql as MySQL;
    use \com\indigloo\Util as Util ;
    
    class Question {
        
        const MODULE_NAME = 'com\indigloo\sc\mysql\Question';

		static function getOnId($questionId) {
			$mysqli = MySQL\Connection::getInstance()->getHandle();
			$questionId = $mysqli->real_escape_string($questionId);
			
            $sql = " select * from sc_question where id = ".$questionId ;
            $row = MySQL\Helper::fetchRow($mysqli, $sql);
            return $row;
		}
		
		static function getAll($filter) {
			
			$mysqli = MySQL\Connection::getInstance()->getHandle();
            $sql = " select * from sc_question order by id desc " ;
			$sql .= $filter ;
			
            $rows = MySQL\Helper::fetchRows($mysqli, $sql);
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
