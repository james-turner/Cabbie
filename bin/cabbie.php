<?php

require_once "autoloader.php";

use Hailocab\Point;
use Hailocab\PointsFilter;
use Hailocab\CSVPointsReader;
use Hailocab\DuplicatePointHeuristic;
use Hailocab\ArrayPointsStack;

$io = new IOStream();

$githubUri = "https://github.com/james-turner/Cabbie";
$io->write("");
$io->write("Full source code can be found at: {$githubUri}");
$io->write("Or you can extract the phar file using the PHP phar utility.");
sleep(2); // sleep for a sec so people can see the output.

// Create stack container for all valid points
$stack = new ArrayPointsStack();

// Create filter
$filter = new PointsFilter($stack);
// Add duplicate point heuristic
$filter->register(new DuplicatePointHeuristic($stack));

// Validate script arguments.
try {
    if(!array_key_exists(1, $argv)){
        throw new InvalidArgumentException("You need to supply a path to a CSV points file as your first argument.");
    }
    $filereader = new CSVPointsReader(realpath($argv[1]));
} catch(InvalidArgumentException $e){
    $io->write($e->getMessage());
    exit;
}

// Exec filter with file reader.
$io->write("################ Starting points filtration ################");
$filter->filter($filereader);


// Pop all the points off the stack into a list.
$list = array();
while(null !== ($last = $stack->pop())){
    $list[] = $last;
}

$io->write("Filtered points set...");
// Reverse all the points in the list and iterate over them outputting their lat/longs.
foreach(array_reverse($list) as $queued){
    $io->write("Point: {$queued->lat}, {$queued->long}");
}

$io->write("################ Ending points filtration ################");