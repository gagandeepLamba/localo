<?php

/**
 *
 *
 * Logger is our own implementation of logger classes.
 * Earlier we were using PEAR Log but that package is not compatible
 * with PHP5 E_STRICT MODE.
 * @see also http://www.indelible.org/php/Log/guide.html
 *
 * @author rajeevj
 * 
 */


namespace webgloo\common {

    use webgloo\common\Configuration as Config ;
    use webgloo\common\Util ;

    class Logger {

        static private $instance = NULL;
        private $sysLevel;
        private $fhandle;
        private $priority;
        private $isDebug = false;

        const ERROR_PRIORITY = 4;
        const WARN_PRIORITY = 3;
        const INFO_PRIORITY = 2;
        const DEBUG_PRIORITY = 1;

        private function __construct() {
            $logfile = NULL;
            //configuration file is one per instance
            // if you are running two different applications in same
            // memory space then you will run into problems
            $logfile = Config::getInstance()->log_location();
            if (!file_exists($logfile)) {
                //create the file
                $this->fhandle = fopen($logfile, "x+");
                //trigger_error('File not found'.$logfile,E_USER_ERROR);
            } else {
                $this->fhandle = fopen($logfile, "a+");
            }
            //open for writing only

            $this->sysLevel = Config::getInstance()->log_level();
            $this->priority = $this->level_to_priority($this->sysLevel);
            $this->isDebug = Config::getInstance()->is_debug();
        }

        function __destruct() {
            fclose($this->fhandle);
        }

        function level_to_priority($level) {

            $priority = Logger::ERROR_PRIORITY;
            if (is_null($level) || empty($level)) {
                return $priority;
            }
            $level = strtoupper($level);

            switch ($level) {
                case 'DEBUG' :
                    $priority = Logger::DEBUG_PRIORITY;
                    break;
                case 'INFO' :
                    $priority = Logger::INFO_PRIORITY;
                    break;

                case 'WARN' :
                    $priority = Logger::WARN_PRIORITY;
                    break;

                case 'ERROR' :
                    $priority = Logger::ERROR_PRIORITY;
                    break;
                default :
                    $priority = Logger::ERROR_PRIORITY;
                    break;
            }

            return $priority;
        }

        static function getInstance() {
            if (self::$instance == NULL) {
                self::$instance = new Logger();
            }

            return self::$instance;
        }

        function debug($message) {
            if (!$this->isDebug) {
                return;
            }
            // keep the original backtrace of caller
            if ($this->isDebug) {
                if (intval(Logger::DEBUG_PRIORITY) >= $this->priority) {
                    $message = Util::stringify($message);
                    $this->logIt(NULL, $message, 'debug');
                }
            }
        }

        function info($message) {

            if (intval(Logger::INFO_PRIORITY) >= $this->priority) {
                //$bt = debug_backtrace();
                $this->logIt(NULL, $message, 'info');
            }
        }

        function warning($message) {

            if (intval(Logger::WARN_PRIORITY) >= $this->priority) {
                $bt = debug_backtrace();
                $this->logIt($bt, $message, 'warning');
            }
        }

        function error($message) {

            if (intval(Logger::ERROR_PRIORITY) >= $this->priority) {
                $bt = debug_backtrace();
                $this->logIt($bt, $message, 'error');
            }
        }

        function trace($file, $line, $message, $trace) {
            $logMessage = "\n" . date("d.m.Y H:i:s") . ' [error] ';
            $logMessage .= $file . ' :' . $line . ' ';
            $logMessage .= $message;
            fwrite($this->fhandle, $logMessage);
            fwrite($this->fhandle, " \n [[Trace-START]] \n\n");
            fwrite($this->fhandle, $trace);
            fwrite($this->fhandle, " \n\n [[Trace-END]] \n\n\n");
        }

        function logIt($bt, $message, $level) {
            // log messages in UTC timezone
            $logMessage = "\n" . date("d.m.Y H:i:s") . ' [' . $level . '] ';

            if (!is_null($bt)) {
                $logMessage .= $bt[0]['file'] . ' :' . $bt[0]['line'] . '  ';
            }

            $logMessage .= $message;

            fwrite($this->fhandle, $logMessage);
        }

    }

}
?>
