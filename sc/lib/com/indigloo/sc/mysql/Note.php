<?php

namespace com\indigloo\sc\mysql {

    use \com\indigloo\mysql as MySQL;
    use \com\indigloo\Util as Util ;
    
    class Note {
        
        const MODULE_NAME = 'com\indigloo\sc\mysql\Question';

		static function getOnId($noteId) {
			$mysqli = MySQL\Connection::getInstance()->getHandle();
            $sql = " select * from sc_note where id = ".$noteId ;
			
            $row = MySQL\Helper::fetchRow($mysqli, $sql);
            return $row;
		}
		
		static function getAll($filter) {
			
			$mysqli = MySQL\Connection::getInstance()->getHandle();
            $sql = " select * from sc_note " ;
			$sql .= $filter ;
			
            $rows = MySQL\Helper::fetchRows($mysqli, $sql);
            return $rows;
			
		}
		
		static function update($noteId,
						       $title,
							   $seoTitle,
                               $description,
                               $category,
                               $location,
                               $tags,
                               $linksJson,
                               $imagesJson,
							   $plevel,
							   $sendDeal,
							   $timeline)
		
		{
			
			$mysqli = MySQL\Connection::getInstance()->getHandle();
            $sql = " update sc_note set title=?, seo_title=?, description=?, category=?, " ;
			$sql .= " location=?, tags=?, links_json=?, images_json=?, p_level=?, " ;
			$sql .= " send_deal=?, timeline=? where id = ?  " ;
			
			
            $code = MySQL\Connection::ACK_OK;
            $stmt = $mysqli->prepare($sql);
            
            
            if ($stmt) {
                $stmt->bind_param("sssssssssisi",
                        $title,
                        $seoTitle,
                        $description,
                        $category,
                        $location,
                        $tags,
                        $linksJson,
                        $imagesJson,
						$plevel,
						$sendDeal,
						$timeline,
						$noteId);
                
                      
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

            $code = MySQL\Connection::ACK_OK;
            $stmt = $mysqli->prepare($sql);
            
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
