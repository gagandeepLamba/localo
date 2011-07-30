<?php

/**
 *
 * @author rajeevj
 * @see also http://dev.mysql.com/doc/refman/5.0/en/error-messages-server.html
 * 
 */

namespace webgloo\common\mysql {

    use webgloo\common\Logger;
    use webgloo\common\mysql as MySQL;

    class Error {

        static function handle($module, $dbHandle) {

            $errorNo = $dbHandle->errno;
            //error code zero means operation success
            if (empty($errorNo)) {
                return $errorNo;
            }

            $map = array(
                1062 => MySQL\Connection::DUPLICATE_KEY
            );

            $message = $module . ':: DB error no:: ' . $errorNo . ' :: message:: ' . $dbHandle->error;
            //This error should be handled separately
            if (array_key_exists($errorNo, $map)) {
                Logger::getInstance()->error($message);
                //get Gloo DB code for this error
                $code = $map[$errorNo];
                return $code;
            } else {
                //do not want to handle this error
                //raise error
                trigger_error($message, E_USER_ERROR);
                exit(1);
            }
        }

    }

}
?>
