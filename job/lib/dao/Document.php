<?php

namespace webgloo\job\dao {

    use webgloo\job\view as view;
    use webgloo\job\mysql as mysql;
    use webgloo\common\Util as Util ;
    
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
