<?php
    
    include 'news-app.inc';
	include($_SERVER['APP_WEB_DIR'] . '/inc/header.inc');
    
    use com\indigloo\Util as Util ;
    use com\indigloo\news\Url as Url ;
    
    
    $postId = $_GET['post_id'];
    Util::isEmpty('post_id',$postId);
    
    $postDao = new \com\indigloo\news\dao\Post();
    $mediaDBRows = $postDao->getMediaOnId($postId);
    
    
    header("content-type:text/xml;charset=utf-8");
    echo "<playlist version=\"1\" xmlns=\"http://xspf.org/ns/0/\">\n";
    echo "<trackList>\n";

    /*
    $images = array();
    
    $image1= array(
        'location' => 'http://www.news.com/media/dd23dd6b3e9f0cc33467',
        'name' => 'image1'
    );
    
    $image2= array(
        'location' => 'http://www.news.com/media/1abe26bd2d81ce76450',
        'name' => 'image2'
    );
    
    $image3= array(
        'location' => 'http://www.news.com/media/a077f4f3c0bc36963028',
        'name' => 'image3'
    );
    
    array_push($images,$image1);
    array_push($images,$image2);
    array_push($images,$image3);
    */
    
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