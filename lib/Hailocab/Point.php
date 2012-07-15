<?php

namespace Hailocab;

class Point {

    public $lat, $long, $timestamp;

    public function __construct($lat, $long, $timestamp){
        $this->lat = $lat;
        $this->long = $long;
        $this->timestamp = $timestamp;
    }

    static public function factory($lat, $long, $timestamp){
        return new self($lat, $long, $timestamp);
    }
}