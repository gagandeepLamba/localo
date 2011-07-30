<?php

//some comments

namespace test\ui {

    class Grid {
        const G100 = 'g100';
        const GA = 'ga';
        const GB = 'gb';
        const GC = 'gc';
        const GD = 'gd';
        const GE = 'ge';
        const GF = 'gf';
        const GH = 'gh';
        const GG = 'gg';

     

        static function numberOfColumns($typeOfGrid) {
          
            return 5 ;
        }

        static function getGridNameValues() {
            //fill with all grid name value pairs
            return self::$grids;
        }

        static function getGridName($typeOfGrid) {
            $name = 'Unknown Grid';
            return $name;
        }

    }

}
?>
