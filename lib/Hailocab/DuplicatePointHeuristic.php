<?php

namespace Hailocab;

/**
 * Duplicate point heuristic indicates whether
 * a supplied point is acceptable or not, it bases
 * it's decision upon the last known point,
 * if either the lat or long of the previous point
 * does not match the supplied point then we can
 * safely assume it's not the same point, thus
 * it's acceptable.
 */
class DuplicatePointHeuristic implements Heuristic {

    /**
     * @var \Hailocab\PointsStack
     */
    private $stack;

    /**
     * @param PointsStack $stack
     */
    public function __construct(PointsStack $stack){
        $this->stack = $stack;
    }

    /**
     * @param Point $point
     * @return bool - Indicates whether the supplied point is acceptable or not.
     */
    public function accept(Point $point)
    {
        if($lastPoint = $this->stack->peek()){
            return ($point->lat !== $lastPoint->lat) || ($point->long !== $lastPoint->long);
        }
        return true;
    }
}