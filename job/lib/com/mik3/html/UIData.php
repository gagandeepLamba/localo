<?php

namespace com\3mik\html {

    class UIData {

        static function getOpeningFilters() {

            //all ui status filters
            $uifilters = array(
                '*' => 'All',
                'A' => 'Active',
                'E' => 'Expired',
                'S' => 'Suspended',
                'C' => 'Closed');
            
            return $uifilters ;
        }

        /**
         *
         * @param <type> $code - DB code as stored in job_opening table
         * 
         */
        static function getOpeningActions($code) {
            //what is coming from DB is - ACTIVE/SUSPEND/CLOSE or A/S/C
            // then we infer an expired opening using dates - E
            // for C - no action possible
            // for E - make active - ACTIVE
            // for A - S/C/extend for 2 week/ extend for 4 week
            
            $data = array( 'E' => array('A' => 'Activate'),
                           'C' => array('A' => 'Activate'),
                           'A' => array('C' => 'Close','S' => 'Suspend','EX2W' => 'Extend for 2 weeks','EX4W' => 'Extend for 4 weeks'));

            return $data[$code];
        }

    }

}
?>
