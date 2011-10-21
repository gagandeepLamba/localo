<?php

namespace com\mik3\dao {

    use com\mik3\view as view;
    use com\mik3\mysql as mysql;
    use com\indigloo\common\Util as Util ;
    
    class Document {

        //use VO object
        function create($document) {
            //store into DB layer
           $data =  mysql\Document::create($document);
           return $data ;
        }
        
    }

}
?>
