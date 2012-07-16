<?php

require_once "autoloader.php";

use Hailocab\Point;
use Hailocab\PointsFilter;
use Hailocab\CSVPointsReader;
use Hailocab\DuplicatePointHeuristic;
use Hailocab\ArrayPointsStack;

$io = new IOStream();

// Create stack container for all valid points
$stack = new ArrayPointsStack();

// Create filter
$filter = new PointsFilter($stack);
// Add duplicate point heuristic
$filter->register(new DuplicatePointHeuristic($stack));

try {
    if(!array_key_exists(1, $argv)){
        throw new InvalidArgumentException("You need to supply path to a CSV points file as your argument.");
    }
    $filereader = new CSVPointsReader(realpath($argv[1]));
} catch(InvalidArgumentException $e){
    $io->write($e->getMessage());
    exit;
}

// Exec filter with
$filter->filter($filereader);

$list = array();
while(null !== ($last = $stack->pop())){
    $list[] = $last;
}

$io->write("Filtered points set...");
foreach(array_reverse($list) as $queued){
    $io->write("Point: {$queued->lat} : {$queued->long}");
}