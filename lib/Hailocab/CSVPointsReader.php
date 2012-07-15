<?php

namespace Hailocab;

class CSVPointsReader implements PointsReader {

    private $filename;
    private $handle;

    public function __construct($csv){
        if(!file_exists($csv)){
            throw new \InvalidArgumentException("File '$csv' could not be found. Please check path.");
        }
        $this->filename = $csv;
        $this->handle = fopen($this->filename, 'r');
    }

    public function __destruct(){
        if(is_resource($this->handle)){
            fclose($this->handle);
        }
    }

    public function readPoint()
    {
        if(!feof($this->handle)){
            $read = fgetcsv($this->handle);
            // Convert the read line into a POINT...
            return Point::factory((float)$read[0], (float)$read[1], (float)$read[2]);
        }
    }

    public function rewind()
    {
        rewind($this->handle);
    }

}