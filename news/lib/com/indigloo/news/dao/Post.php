<?php

namespace com\indigloo\news\dao {

    
    use com\indigloo\Util as Util ;
    use com\indigloo\news\mysql as mysql;
    
    class Post {

        function create($title,$summary,$description) {
            $data = mysql\Post::create($title,$summary,$description);
            return $data ;
        }
        
        function getRecordOnId($postId) {
            $row = mysql\Post::getRecordOnId($postId);
            return $row ;
        }
        
        function getRecords() {
            $rows = mysql\Post::getRecords();
            return $rows ;

        }
    }

}
?>
