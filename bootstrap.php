<?php

// Set LOAD PATH directory
define('LOAD_PATH', __DIR__);

// Update include path to include the lib directory.
set_include_path(implode(PATH_SEPARATOR, array(
    realpath(LOAD_PATH . "/lib"),
    get_include_path(),
)));

// Autoloader
spl_autoload_register(function($className){
    $path = str_replace('\\', '/', $className) . ".php";
    require_once $path;
});