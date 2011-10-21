<?php
    
	function __autoload($className) {

    //replace double slashes in class name (PHP 5.3 namespace convention)
    // with a forrward slash (or PATH_SEPARATOR on your box)
    $file = str_replace('\\', '/', $className) . '.php';
    
    //try loading from APP_LIB_PATH first
    $libpaths = $_SERVER['APP_LIB_PATH'];
    foreach($libpaths as $libpath) {
        $path = $libpath.'/'.$file; 
        
        if (file_exists($path) && is_readable($path)) {
            include_once $path;
            return;
        }
    }
    
    
    //now try loading old style class names with underscores
    // from php.ini include_path try
    
    $file = str_replace('_', '/', $className) . '.php';
    foreach (explode(PATH_SEPARATOR, ini_get('include_path')) as $base_path) {
        $path = "$base_path/$file";
        if (file_exists($path) && is_readable($path)) {
            include_once $path;
            return;
        }
    }
    
    $message = sprintf("Class loader is unable to load  %s ",$className);
    trigger_error($message, E_USER_ERROR);
}

?>
