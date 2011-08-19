<?php

//News application class loader
function __autoload($className) {

    //replace double slashes in class name (PHP 5.3 namespace convention)
    // with a forrward slash (or PATH_SEPARATOR on your box)
    $file = str_replace('\\', '/', $className) . '.php';

    // base path should be set in system include file
    // we define class loading behavior per application
    $base_path = $_SERVER['APP_LIB_DIR'];
    $path = $base_path.'/'.$file;
    
    //first use APP_LIB_DIR absolute path for loading
    if (file_exists($path) && is_readable($path)) {
        include_once $path;
        return;
    }
    
    //try old style names with underscores
     $file = str_replace('_', '/', $className) . '.php';
    //try loading from PHP include_path
    foreach (explode(PATH_SEPARATOR, ini_get('include_path')) as $base_path) {
        $path = "$base_path/$file";
        if (file_exists($path) && is_readable($path)) {
            include_once $path;
            return;
        }
    }
    
    trigger_error(" JOB App cannot load class $className " , E_USER_ERROR);
}

?>
