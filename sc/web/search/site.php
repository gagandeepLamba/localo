<?php
	//sc/search/site.php
	include('sc-app.inc');
	include($_SERVER['APP_WEB_DIR'] .'/inc/header.inc');
	include($_SERVER['WEBGLOO_LIB_ROOT'] .'/ext/sphinx/sphinxapi.php');	

	use \com\indigloo\Url ;

	$token = Url::tryQueryParam("gs");
	if(is_null($token)) {
		header("location: / ");
	}

	//search on this token
	$connx = new \com\indigloo\sc\search\Sphinx();
	$data = $connx->query($token);
			
	if($data["total"] > 0 ) {
		$arrayIds = $data["ids"];
		include('inc/results.php') ;
	} else {
		include('inc/noresult.php');
	}

?>
