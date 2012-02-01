<?php

namespace com\indigloo\sc\mysql {

    use \com\indigloo\mysql as MySQL;
    use \com\indigloo\Util as Util ;
    
    class Note {
        
        const MODULE_NAME = 'com\indigloo\sc\mysql\Question';

		static function getAll($filter) {
			
			$mysqli = MySQL\Connection::getInstance()->getHandle();
            $sql = " select * from sc_note " ;
			$sql .= $filter ;
			
            $rows = MySQL\Helper::fetchRows($mysqli, $sql);
            return $rows;
			
		}
		
        static function create($type,
							   $title,
                               $seoTitle,
                               $description,
                               $category,
                               $location,
                               $tags,
							   $brand,
							   $userId,
                               $linksJson,
                               $imagesJson,
							   $plevel,
							   $sendDeal,
							   $timeline) {

            $mysqli = MySQL\Connection::getInstance()->getHandle();
            $sql = " insert into sc_note(title,seo_title,description,category,location,tags, " ;
            $sql .= " brand,user_id,links_json,images_json,created_on,p_level,send_deal,n_type,timeline) ";
            $sql .= " values(?,?,?,?,?,?,?,?,?,?,now(),?,?,?,?) ";

            $dbCode = MySQL\Connection::ACK_OK;
            $stmt = $mysqli->prepare($sql);
            $lastInsertId = NULL ;
            $categoryId = 1 ;
            
            if ($stmt) {
                $stmt->bind_param("sssssssssssiss",
                        $title,
                        $seoTitle,
                        $description,
                        $category,
                        $location,
                        $tags,
						$brand,
						$userId,
                        $linksJson,
                        $imagesJson,
						$plevel,
						$sendDeal,
						$type,
						$timeline);
                
                      
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
