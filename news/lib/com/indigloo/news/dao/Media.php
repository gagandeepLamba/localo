<?php

namespace com\indigloo\news\dao {

    
    use com\indigloo\Util as Util ;
    use com\indigloo\news\mysql as mysql;
    
    class Media {

        function add($postId,$mediaVO) {
            $mediaId = mysql\Media::add($postId,$mediaVO);
            if(empty($mediaId)) {
                trigger_error("Error ading media data to database", E_USER_ERROR);
            }
            
            return $mediaId ;
        }
        
        function getMediaOnPostId($postId) {
             $rows = mysql\Media::getMediaOnPostId($postId);
             return $rows;
        }
    }

}

?>
