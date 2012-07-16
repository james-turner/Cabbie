<?php

// Autoloader
spl_autoload_register(function($className){
    $path = str_replace('\\', '/', $className) . ".php";
    require_once $path;
});