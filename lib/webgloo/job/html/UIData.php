<?php

namespace webgloo\job\html {

    class UIData {

        static function getStatusFilters() {

            //all ui status filters
            $uifilters = array('*' => 'All',
                'A' => 'Active',
                'E' => 'Expired',
                'S' => 'Suspended',
                'C' => 'Closed');
            
            return $uifilters ;
        }

    }

}
?>
