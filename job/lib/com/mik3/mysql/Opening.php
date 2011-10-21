<?php

namespace com\3mik\mysql {

    use com\indigloo\common\mysql as MySQL;

    class Opening {
        const MODULE_NAME = 'webgloo\job\mysql\Opening';

        static function getAllRecords() {
            $mysqli = MySQL\Connection::getInstance()->getHandle();
            //filter on status = 'A (ACTIVE) and expire_on > now()
            $sql = " select * from job_opening where status = 'A' and ( expire_on > now() ) order by created_on DESC" ;
            $rows = MySQL\Helper::fetchRows($mysqli, $sql);
            return $rows;
        }

        static function getRecordsOnOrgId($organizationId,$filter) {
            $mysqli = MySQL\Connection::getInstance()->getHandle();
            //show all records for organization
            $status = $filter["status"];

            $sql = NULL ;
            switch($status) {
                //All
                case '*' :
                    $sql .= " select * from job_opening where org_id = {orgId} order by expire_on " ;
                    $sql = str_replace(array(0 => "{orgId}"), array(0 => $organizationId), $sql);
                    break ;
                 //active,
                 case 'A' : 
                    $sql .= " select * from job_opening where org_id = {orgId} and (expire_on > now()) order by expire_on " ;
                    $sql = str_replace(array(0 => "{orgId}"), array(0 => $organizationId), $sql);
                    break ;
                  // suspended, closed
                  case 'S' : case 'C' :
                    $sql .= " select * from job_opening where org_id = {orgId} and status = '{status}' order by expire_on " ;
                    $sql = str_replace(array(0 => "{orgId}" , 1 => "{status}"), array(0 => $organizationId, 1 => $status), $sql);
                    break ;
                  case 'E' :
                    $sql .= " select * from job_opening where org_id = {orgId} and (expire_on < now()) order by expire_on " ;
                    $sql = str_replace(array(0 => "{orgId}"), array(0 => $organizationId), $sql);
                    break ;
                  default:
                      \trigger_error("Unknown opening status ", E_USER_ERROR);

            }
            
            
            $rows = MySQL\Helper::fetchRows($mysqli, $sql);
            return $rows;
        }
        
        static function getRecordOnId($openingId) {
            $mysqli = MySQL\Connection::getInstance()->getHandle();
            $sql = " select * from job_opening where id = ".$openingId ;
            $row = MySQL\Helper::fetchRow($mysqli, $sql);
            return $row;
        }

        static function getEditRecordOnId($organizationId,$openingId) {
            $mysqli = MySQL\Connection::getInstance()->getHandle();
            $sql = " select * from job_opening where id = ".$openingId. " and org_id =".$organizationId ;
            $row = MySQL\Helper::fetchRow($mysqli, $sql);
            return $row;
        }

        static function create($openingVO) {

            $mysqli = MySQL\Connection::getInstance()->getHandle();

            //calculate expire_on value to go in DB
            // using the value passed in from UI
            //@todo - remove this UI/DB coupling via DAO layer

            $expireOn = array(
                '2W' => '(now() + INTERVAL 2 WEEK)',
                '1M' => '(now() + INTERVAL 1 MONTH)',
                '2M' => '(now() + INTERVAL 2 MONTH)');

            $expireOnValue = $expireOn[$openingVO->expireOn];
            
            if(!isset($expireOnValue)) {
                trigger_error('Wrong expired on value found', E_USER_ERROR);
            }

            $sql = " insert into job_opening(title,description,bounty,status,org_id,created_by, " ;
            $sql .= " organization_name, skill, location,created_on,expire_on, min_experience,max_experience) ";
            $sql .= " values(?,?,?,?,?,?,?,?,?,now(), {expireOn} ,?,?) ";
            
            $sql = str_replace("{expireOn}", $expireOnValue, $sql);
            $dbCode = MySQL\Connection::ACK_OK;
            
            $stmt = $mysqli->prepare($sql);
            if ($stmt) {
                $stmt->bind_param("ssssissssss",
                        $openingVO->title,
                        $openingVO->description,
                        $openingVO->bounty,
                        $openingVO->status,
                        $openingVO->organizationId,
                        $openingVO->createdBy,
                        $openingVO->organizationName,
                        $openingVO->skill,
                        $openingVO->location,
                        $openingVO->minExperience,
                        $openingVO->maxExperience);

                $stmt->execute();

                if ($mysqli->affected_rows != 1) {
                    $dbCode = MySQL\Error::handle(self::MODULE_NAME, $stmt);
                }
                $stmt->close();
            } else {
                $dbCode = MySQL\Error::handle(self::MODULE_NAME, $mysqli);
            }

            return $dbCode;
        }

        static function update($openingId, $openingVO) {

            $mysqli = MySQL\Connection::getInstance()->getHandle();

            $sql = " update job_opening set title = ?, description = ?, skill =?, bounty = ?, " ;
            $sql .= " location = ?, min_experience =?, max_experience = ? where id = ? and org_id = ? ";
            $dbCode = MySQL\Connection::ACK_OK;

            $stmt = $mysqli->prepare($sql);
            //returns FALSE if prepare flopped
            if ($stmt) {
                $stmt->bind_param("sssisiiii",
                        $openingVO->title,
                        $openingVO->description,
                        $openingVO->skill,
                        $openingVO->bounty,
                        $openingVO->location,
                        $openingVO->minExperience,
                        $openingVO->maxExperience,
                        $openingId,
                        $openingVO->organizationId);

                $stmt->execute();
                if ($mysqli->affected_rows != 1) {
                    $dbCode = MySQL\Error::handle(self::MODULE_NAME, $stmt);
                }
                $stmt->close();
            } else {
                $dbCode = MySQL\Error::handle(self::MODULE_NAME, $mysqli);
            }
            return $dbCode;
        }

        static function updateStatus($organizationId, $openingId,$status) {
            $mysqli = MySQL\Connection::getInstance()->getHandle();

            $sql = " update job_opening set status = ? where id = ? and org_id = ? " ;
            $dbCode = MySQL\Connection::ACK_OK;

            $stmt = $mysqli->prepare($sql);
            
            if ($stmt) {
                $stmt->bind_param("sii",$openingId,$organizationId,$status);
                $stmt->execute();
                if ($mysqli->affected_rows != 1) {
                    $dbCode = MySQL\Error::handle(self::MODULE_NAME, $stmt);
                }
                $stmt->close();
            } else {
                $dbCode = MySQL\Error::handle(self::MODULE_NAME, $mysqli);
            }
            return $dbCode;
        }

        static function extendLife($organizationId, $openingId,$days) {
            $mysqli = MySQL\Connection::getInstance()->getHandle();

            $sql = " update job_opening set expire_on = {expireOn} where id = ? and org_id = ? " ;
            $sql = \str_replace("{expireOn}" , "(expire_on + INTERVAL ".$days. " DAY )", $sql);
            $dbCode = MySQL\Connection::ACK_OK;

            $stmt = $mysqli->prepare($sql);
            
            if ($stmt) {
                $stmt->bind_param("ii",$openingId,$organizationId);
                $stmt->execute();
                if ($mysqli->affected_rows != 1) {
                    $dbCode = MySQL\Error::handle(self::MODULE_NAME, $stmt);
                }
                $stmt->close();
            } else {
                $dbCode = MySQL\Error::handle(self::MODULE_NAME, $mysqli);
            }
            return $dbCode;
        }

    }

}
?>
