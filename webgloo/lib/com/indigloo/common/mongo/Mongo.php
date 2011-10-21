<?php

namespace com\indigloo\common\mongo {

    class Mongo {

        public static function getHandle() {
            //use absolute package path
            $m = new \Mongo();
            $db = $m->JOBDB;
            return $db;
        }
        
    }

}
?>
