<?php


namespace webgloo\job\mysql {

    use webgloo\common\mysql as MySQL ;

    class Organization {
        const MODULE_NAME = 'webgloo\job\mysql\Organization';

        static function getRecords() {
            $mysqli = MySQL\Connection::getInstance()->getHandle();
            $sql = " select * from job_org" ;
            $rows = MySQL\Helper::fetchRows($mysqli, $sql);
            return $rows;
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

    }

}
?>
