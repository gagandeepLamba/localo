<?php

namespace com\3mik\dao {

    use com\3mik\view as view;
    use com\3mik\mysql as mysql;
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
