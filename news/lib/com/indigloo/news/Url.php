<?php

    namespace com\indigloo\news {
        
        class Url {
            
            static function base () {
                return 'http://'.$_SERVER["HTTP_HOST"] ;
                
            }
            
            static function getJWRotatorTrackURI($postId) {
                // possible transition styles are
                // fade, bgfade, blocks, bubbles, circles, flash, fluids, lines or slowfade
                $trackURI = '/data/jwrotator.php?post_id={postId}&rotatetime=5&repeat=repeat&transition=blocks' ;
                $trackURI = str_replace("{postId}", $postId, $trackURI);
                return self::base().$trackURI;
                
            }
            
            static function getJWRotatorSwfURI() {
                return self::base().'/lib/jwrotator/imagerotator.swf' ;
            }
            
        }
        
    }
    
?>