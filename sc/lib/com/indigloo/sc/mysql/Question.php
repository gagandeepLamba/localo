<?php

namespace com\indigloo\sc\mysql {

    use \com\indigloo\mysql as MySQL;
    use \com\indigloo\Util as Util ;
    
    class Question {
        
        const MODULE_NAME = 'com\indigloo\sc\mysql\Question';

		static function getAll() {
			
			$mysqli = MySQL\Connection::getInstance()->getHandle();
            $sql = " select * from sc_question " ;
			
            $rows = MySQL\Helper::fetchRows($mysqli, $sql);
            return $rows;
			
		}
		
        static function create($title,
                               $seoTitle,
                               $description,
                               $category,
                               $location,
                               $tags,
                               $linksJson,
                               $imagesJson) {

            $mysqli = MySQL\Connection::getInstance()->getHandle();
            $sql = " insert into sc_question(title,seo_title,description,category_id,category, " ;
            $sql .= " location,tags,links_json,images_json,created_on) ";
            $sql .= " values(?,?,?,?,?,?,?,?,?,now()) ";

            $dbCode = MySQL\Connection::ACK_OK;
            $stmt = $mysqli->prepare($sql);
            $lastInsertId = NULL ;
            $categoryId = 1 ;
            
            if ($stmt) {
                $stmt->bind_param("sssisssss",
                        $title,
                        $seoTitle,
                        $description,
                        $categoryId,
                        $category,
                        $location,
                        $tags,
                        $linksJson,
                        $imagesJson);
                
                      
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
	}
}
?>
