<?php

class ErroneousPointsTest extends PHPUnit_Framework_TestCase {

    /**
     * @var Hailocab\PointsFilter
     */
    private $filter;

    /**
     * @var PHPUnit_Framework_MockObject_MockObject
     */
    private $mockStack;

    /**
     * @var PHPUnit_Framework_MockObject_MockObject
     */
    private $mockReader;

    public function setUp(){
        $this->mockReader = $this->getMock('Hailocab\PointsReader', array(), array(), '', false);
        $this->mockStack = $this->getMock('Hailocab\PointsStack', array(), array(), '', false);
        $this->filter = new Hailocab\PointsFilter($this->mockStack);

    }

    /**
     * @test
     */
    public function rejectAPointIfASingleHeuristicCheckFails(){

        $mockPoint = $this->getMock('Hailocab\Point', array(), array(), '', false);

        $this->mockReader->expects($this->at(0))
                         ->method('readPoint')
                         ->will($this->returnValue($mockPoint));
        $this->mockReader->expects($this->at(1))
                         ->method('readPoint')
                         ->will($this->returnValue(null));

        $mockHeuristic = $this->getMock('Hailocab\Heuristic');
        $mockHeuristic->expects($this->once())
                      ->method('accept')
                      ->with($mockPoint)
                      ->will($this->returnValue(false));

        // Make sure the stack push has not been invoked.
        $this->mockStack->expects($this->never())
                        ->method('push');


        $this->filter->register($mockHeuristic);
        $this->filter->filter($this->mockReader);

    }

    /**
     * @test
     */
    public function allPointsPassIfNoHeuristicsApplied(){

        $numOfPoints = 0;
        $phpunit = $this;
        $this->mockReader->expects($this->atLeastOnce())
                         ->method('readPoint')
                         ->will($this->returnCallback(function()use(&$numOfPoints, $phpunit){
                             if($numOfPoints < 5){
                                 $numOfPoints++;
                                 return $phpunit->getMock('Hailocab\Point', array(), array(), '', false);
                             }
                             return null;
                        }));

        // expect the 5 points from the reader to be applied
        $this->mockStack->expects($this->exactly(5))
                        ->method('push')
                        ->with($this->isInstanceOf('Hailocab\Point'));

        $this->filter->filter($this->mockReader);

    }

}