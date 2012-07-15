<?php

namespace Hailocab;

interface PointsStack {

    public function push($element);
    public function pop();
    public function peek();

}