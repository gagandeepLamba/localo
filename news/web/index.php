<?php

    include 'news-app.inc';
	include($_SERVER['APP_WEB_DIR'] . '/inc/header.inc');
	
	use com\indigloo\Configuration as Config ;
	use com\indigloo\Logger  as Logger ;
	use com\indigloo\Util  as Util ;
	
     
    $router = new com\indigloo\news\Router();
    //initialize news app routing table
    $router->initTable();
    $route = $router->getRoute($_SERVER['REQUEST_URI']);
    
	
	if(is_null($route)) {
		//No valid route for this path
		$message = sprintf("No route for path %s",$_SERVER['REQUEST_URI']);
		Logger::getInstance()->error($message);
		
		$controller = new Gloo_Controller_Null();
		$controller->process();
		exit;

    } else {
		$controllerName = $route["action"];
		
		if(Config::getInstance()->is_debug()) {
			$strParams = Util::stringify($route["params"]);
			$strOptions = Util::stringify($route["options"]);
			
			$message = sprintf("controller %s :: params %s :: options %s  for path %s",
							   $controllerName,$strParams, $strOptions, $_SERVER['REQUEST_URI']);
			Logger::getInstance()->debug($message);
		}
		
		$controller = new $controllerName();
		$controller->process($route["params"], $route["options"]);
		
	
	}

?>
