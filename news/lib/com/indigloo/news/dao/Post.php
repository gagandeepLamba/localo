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
            $data = mysql\Post::getRecordOnId($postId);
            return $data ;
        }
    }

}
?>
