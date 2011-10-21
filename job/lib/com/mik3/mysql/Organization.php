<?php


namespace com\3mik\mysql {

    use com\indigloo\common\mysql as MySQL ;

    class Organization {
        const MODULE_NAME = 'webgloo\job\mysql\Organization';

        static function getRecordOnId($organizationId) {
            $mysqli = MySQL\Connection::getInstance()->getHandle();
            $sql = " select * from job_org where id = ".$organizationId ;
            $row = MySQL\Helper::fetchRow($mysqli, $sql);
            return $row;
        }

        static function create($organizationVO) {
            
            $mysqli = MySQL\Connection::getInstance()->getHandle();
            
            $sql = " insert into job_org(name,domain,p_email,description,created_on) ";
            $sql .= " values(?,?,?,?,now()) ";

            $dbCode = MySQL\Connection::ACK_OK ;

            $stmt = $mysqli->prepare($sql);
            if ($stmt) {
                $stmt->bind_param("ssss",
                        $organizationVO->name,
                        $organizationVO->domain,
                        $organizationVO->email,
                        $organizationVO->description);

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

        static function update($organizationId, $name, $website, $description) {
            $mysqli = MySQL\Connection::getInstance()->getHandle();

            $sql = " update job_org set name = ?,website = ?,description = ? where id = ?";
            $dbCode = MySQL\Connection::ACK_OK;
            
            $stmt = $mysqli->prepare($sql);
            //returns FALSE if prepare flopped
            if ($stmt) {
                $stmt->bind_param("sssi",
                        $name,
                        $website,
                        $description,
                        $organizationId);

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
