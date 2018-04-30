<?php

/**
 * Guide test case.
 */
use app\index\model\Guide;

class GuideTest extends PHPUnit_Framework_TestCase
{

    /**
     *
     * @var Guide
     */
    private $guide;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();
        
        
        $this->guide = new Guide(/* parameters */);
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        // TODO Auto-generated GuideTest::tearDown()
        $this->guide = null;
        
        parent::tearDown();
    }

    /**
     * Constructs the test case.
     */
    public function __construct()
    {
        // TODO Auto-generated constructor
    }

    /**
     * Tests Guide->__construct()
     */
    public function test__construct()
    {
        // TODO Auto-generated GuideTest->test__construct()
        $this->markTestIncomplete("__construct test not implemented");
        
        $this->guide->__construct(/* parameters */);
    }

    /**
     * Tests Guide->start_talk()
     */
    public function testStart_talk()
    {
        // TODO Auto-generated GuideTest->testStart_talk()
        $this->markTestIncomplete("start_talk test not implemented");
        
        $this->guide->start_talk(/* parameters */);
    }

    /**
     * Tests Guide->lastWaiter()
     */
    public function testLastWaiter()
    {
        // TODO Auto-generated GuideTest->testLastWaiter()
        $this->markTestIncomplete("lastWaiter test not implemented");
        
        $this->guide->lastWaiter(/* parameters */);
    }

    /**
     * Tests Guide->newWaiter()
     */
    public function testNewWaiter()
    {
        // TODO Auto-generated GuideTest->testNewWaiter()
        $this->markTestIncomplete("newWaiter test not implemented");
        
        $this->guide->newWaiter(/* parameters */);
    }
}

