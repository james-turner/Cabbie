<?php

namespace Hailocab;

class ArrayPointsStack implements PointsStack {

    private $points = array();

    public function push($element)
    {
        array_push($this->points, $element);
    }

    public function pop()
    {
        return array_pop($this->points);
    }

    public function peek()
    {
        $element = end($this->points);
        if(false !== $element){
            return $element;
        }
    }
}