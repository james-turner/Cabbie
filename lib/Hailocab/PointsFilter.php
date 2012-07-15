<?php

namespace Hailocab;

class PointsFilter {

    /**
     * @var array
     */
    private $heuristics = array();

    /**
     * @var \Hailocab\PointsStack
     */
    private $filtered;

    /**
     * @param PointsStack $onto
     */
    public function __construct(PointsStack $onto){
        $this->filtered = $onto;
    }

    /**
     * @param Heuristic $h
     * @return void
     */
    public function register(Heuristic $h){
        $this->heuristics[] = $h;
    }

    /**
     * @param Heuristic $h
     * @return void
     */
    public function unregister(Heuristic $h){
        if($idx = array_search($h, $this->heuristics)){
            unset($this->heuristics[$idx]);
        }
    }

    /**
     * @param PointsReader $r
     * @return void
     */
    public function filter(PointsReader $reader){

        while(null !== ($next = $reader->readPoint())){
            $valid = true;
            foreach($this->heuristics as $h){
                // If one heuristic rejects this point
                // then set valid to false, and break the
                // heuristic checks, move to next point.
                if(!$h->accept($next)){
                    $valid = false; break;
                }
            }
            if($valid){
                $this->filtered->push($next);
            }
        }

    }

}