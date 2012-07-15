<?php

class CSVPointsReaderTest extends PHPUnit_Framework_TestCase {

    /**
     * @var \Hailocab\CSVPointsReader
     */
    private $reader;

    private $fixture;

    public function setUp(){
        $this->fixture = __DIR__ . "/../../sample-data/points.csv";
        $this->reader = new \Hailocab\CSVPointsReader($this->fixture);
    }

    /**
     * @test
     */
    public function readPointGivesMeTheFirstPoint(){

        $this->assertThat($this->reader->readPoint(), $this->isInstanceOf('\Hailocab\Point'));

    }

    /**
     * @test
     */
    public function readTwoPointsGivesMeDifferingPoints(){

        $first = $this->reader->readPoint();
        $second = $this->reader->readPoint();

        $this->assertNotEquals($first, $second);
        $this->assertNotSame($first, $second);

    }

    /**
     * @test
     */
    public function readPointsReturnsNullWhenReachesTheEndOfTheData(){

        // Contains 227 lines to read.
        for($i=0; $i < 227; $i++){
            $this->assertThat($this->reader->readPoint(), $this->isInstanceOf('Hailocab\Point'));
        }

        // 228 should return null
        $this->assertNull($this->reader->readPoint());

    }

}