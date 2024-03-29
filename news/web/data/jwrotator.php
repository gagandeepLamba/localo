<?php
    
    include 'news-app.inc';
	include($_SERVER['APP_WEB_DIR'] . '/inc/header.inc');
    
	/*
	 + Embed jwrotator swf file using following code
	 
	<embed src="<?php echo $jwRotatorSwfURI; ?>"
		wmode=opaque
		allowscriptaccess="always"
		allowfullscreen="true"
		allowresize="true"
		width="600" height="400"
		flashvars="file=<?php echo $jwRotatorTrackURI; ?>" />
                                 
	*/
	
    use com\indigloo\Util as Util ;
    use com\indigloo\news\Url as Url ;
    
    
    $postId = $_GET['post_id'];
    Util::isEmpty('post_id',$postId);
    
    $postDao = new \com\indigloo\news\dao\Post();
    $mediaDBRows = $postDao->getMediaOnId($postId);
    
    
    header("content-type:text/xml;charset=utf-8");
    echo "<playlist version=\"1\" xmlns=\"http://xspf.org/ns/0/\">\n";
    echo "<trackList>\n";
	    
    foreach($mediaDBRows as $mediaDBRow) {
        $image = array();
        $image['name'] = $mediaDBRow['original_name'];
        $image['location'] = Url::base().'/'.$mediaDBRow['bucket'].'/'.$mediaDBRow['stored_name'];
        spew_track($image);
    }
    
    echo "</trackList>\n";
    echo "</playlist>\n";
    
    //print tracks in XSPF format
    function spew_track($image) {
            echo "\t<track>\n";
            echo "\t\t<title>".$image['name']."</title>\n";
            echo "\t\t<meta rel=\"type\">jpg</meta> \n" ;
            echo "\t\t<location>".$image['location']. "</location>\n";
            echo "\t\t<info> http://www.indigloo.com </info>\n";
            echo "\t</track>\n";

    }
        
?>