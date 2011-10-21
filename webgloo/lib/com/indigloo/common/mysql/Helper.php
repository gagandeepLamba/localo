<?php

/**
 *
 * @author rajeevj
 */

namespace com\indigloo\common\mysql {

    use com\indigloo\common\Logger;
    use com\indigloo\common\Configuration as Config;
    use com\indigloo\common\mysql as MySQL;

    class Helper {

        static function fetchRows($mysqli, $sql) {

            if (is_null($sql) || is_null($mysqli)) {
                trigger_error(" Fatal: Null mysqli connx or null SQL supplied", E_USER_ERROR);
            }

            $rows = NULL;
            $result = $mysqli->query($sql);
            if ($result) {
                $rows = array();
                while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
                    array_push($rows, $row);
                }
            } else {
                trigger_error($mysqli->error, E_USER_ERROR);
            }

            $result->free();
            if (Config::getInstance()->is_debug()) {
                Logger::getInstance()->debug(" Fetch rows SQL >> " . $sql);
                Logger::getInstance()->debug(" number of rows >> " . sizeof($rows));
            }

            return $rows;
        }

        static function fetchRow($mysqli, $sql) {

            if (is_null($sql) || is_null($mysqli)) {
                trigger_error(" Fatal: Null mysqli connx or null SQL supplied", E_USER_ERROR);
            }

            $row = NULL;
            $result = $mysqli->query($sql);
            if ($result) {
                $row = $result->fetch_array(MYSQLI_ASSOC);
            } else {
                trigger_error($mysqli->error, E_USER_ERROR);
            }
            $result->free();
            if (Config::getInstance()->is_debug()) {
                Logger::getInstance()->debug(" Row SQL >> " . $sql);
            }

            return $row;
        }

        static function executeSQL($mysqli, $sql) {
            if (Config::getInstance()->is_debug()) {
                Logger::getInstance()->debug("execute SQL >> " . $sql);
            }
            $stmt = $mysqli->prepare($sql);
            if ($stmt) {
                $stmt->execute();
                $stmt->close();
            } else {
                trigger_error($mysqli->error, E_USER_ERROR);
            }
        }

        //@todo -fix this paginator
        static function paginate($sql, $paginator, $orderByClause=NULL) {
            if (empty($paginator)) {
                trigger_error('No pagination object', E_USER_ERROR);
            }
            if (empty($orderByClause)) {
                trigger_error('No order by clause for paginator', E_USER_ERROR);
            }

            $size = $paginator->getPageSize();
            if (empty($size)) {
                trigger_error('paginator is without page size ', E_USER_ERROR);
            }
            $offset = 0 + ($paginator->getPage() - 1 ) * $size;
            $sql = $sql . $orderByClause . " LIMIT  " . $offset . "," . $size;

            return $sql;
        }

    }

}
?>
