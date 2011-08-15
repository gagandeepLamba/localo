<?php

namespace webgloo\job\mysql {

    use webgloo\common\mysql as MySQL;

    class Opening {
        const MODULE_NAME = 'webgloo\job\mysql\Opening';

        static function getAllRecords() {
            $mysqli = MySQL\Connection::getInstance()->getHandle();
            //filter on status = 'A (ACTIVE) and expire_on > now()
            $sql = " select * from job_opening where status = 'A' and ( expire_on > now() ) order by expire_on" ;
            $rows = MySQL\Helper::fetchRows($mysqli, $sql);
            return $rows;
        }

        static function getRecordsOnOrgId($organizationId) {
            $mysqli = MySQL\Connection::getInstance()->getHandle();
            //show all records for organization
            $sql = " select * from job_opening where org_id = {orgId} order by expire_on" ;
            $sql = str_replace("{orgId}",$organizationId, $sql);
            $rows = MySQL\Helper::fetchRows($mysqli, $sql);
            return $rows;
        }
        
        static function getRecordOnId($openingId) {
            $mysqli = MySQL\Connection::getInstance()->getHandle();
            $sql = " select * from job_opening where id = ".$openingId ;
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
            $sql .= " organization_name, skill, location,created_on,expire_on) ";
            $sql .= " values(?,?,?,?,?,?,?,?,?,now(), {expireOn} ) ";
            $sql = str_replace("{expireOn}", $expireOnValue, $sql);


            $dbCode = MySQL\Connection::ACK_OK;
            
            $stmt = $mysqli->prepare($sql);
            if ($stmt) {
                $stmt->bind_param("ssssissss",
                        $openingVO->title,
                        $openingVO->description,
                        $openingVO->bounty,
                        $openingVO->status,
                        $openingVO->organizationId,
                        $openingVO->createdBy,
                        $openingVO->organizationName,
                        $openingVO->skill,
                        $openingVO->location);

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

            $sql = " update job_opening set title = ?, description = ? , bounty = ? , status = ? where id = ? and org_id =? ";
            $dbCode = MySQL\Connection::ACK_OK;

            $stmt = $mysqli->prepare($sql);
            //returns FALSE if prepare flopped
            if ($stmt) {
                $stmt->bind_param("ssssii",
                        $openingVO->title,
                        $openingVO->description,
                        $openingVO->bounty,
                        $openingVO->status,
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

    }

}
?>
