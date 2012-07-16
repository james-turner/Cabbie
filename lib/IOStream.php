<?php

class IOStream {
    public function __construct(){
        defined("STDIN") || define("STDIN", fopen("php://stdin", "r"));
        defined("STDOUT") || define("STDOUT", fopen("php://stdout", "w"));
        defined("STDERR") || define("STDERR", fopen("php://stderr", "a"));
    }
    public function read(){
        return fread(STDIN, 1024);
    }
    public function write($what){
        $what = trim($what) . "\n";
        fwrite(STDOUT, $what);
    }
}