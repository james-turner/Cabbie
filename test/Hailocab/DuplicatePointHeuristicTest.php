<?php

class DuplicatePointHeuristicTest extends PHPUnit_Framework_TestCase {

    /**
     * @var Hailocab\DuplicatePointHeuristic
     */
    private $heuristic;

    private $mockStack;

    public function setUp(){
        $this->mockStack = $this->getMock('Hailocab\PointsStack', array(), array(), '', false);
        $this->heuristic = new \Hailocab\DuplicatePointHeuristic($this->mockStack);
    }

    /**
     * @test
     */
    public function subsequentIdenticalPointsAreNotAccepted(){

        // Fixture point on the back of the stack
        $peekPoint = new \Hailocab\Point(51.23123,2.1231232,12889298);

        // Expect check on current last stack value

        $this->mockStack->expects($this->once())
              ->method('peek')
              ->will($this->returnValue($peekPoint));


        // Execute
        $actual = $this->heuristic->accept(new \Hailocab\Point(51.23123,2.1231232,12889219));
        $this->assertFalse($actual);
    }

    /**
     * @test
     */
    public function subsequentDifferingPointsAreAccepted(){

        // Fixture point on the back of the stack
        $peekPoint = new \Hailocab\Point(51.23123,2.3838292,12889298);

        // Expect check on current last stack value

        $this->mockStack->expects($this->once())
              ->method('peek')
              ->will($this->returnValue($peekPoint));

        // Execute
        $actual = $this->heuristic->accept(new \Hailocab\Point(51.23123,2.1231232,12889219));
        $this->assertTrue($actual);
    }
}