<?php

namespace webgloo\job\mysql {

    use webgloo\common\mysql as MySQL;

    class Opening {
        const MODULE_NAME = 'webgloo\job\mysql\Opening';

        static function getAllRecords() {
            $mysqli = MySQL\Connection::getInstance()->getHandle();
            $sql = " select * from job_opening order by created_on desc" ;
            $rows = MySQL\Helper::fetchRows($mysqli, $sql);
            return $rows;
        }

        static function getRecordsOnOrgId($organizationId) {
            $mysqli = MySQL\Connection::getInstance()->getHandle();
            $sql = " select * from job_opening where org_id = {orgId} order by created_on desc" ;
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

            $sql = " insert into job_opening(title,description,bounty,status,org_id,created_by, " ;
            $sql .= " organization_name, skill, location,created_on) ";
            $sql .= " values(?,?,?,?,?,?,?,?,?,now()) ";

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
