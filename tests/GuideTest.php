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

    }


    public function testStart_talk()
    {
        $userInput = "逼";
        $guide = new Guide("oG24uwN10qZXaFm9KZLdeRj2inu0",$userInput);
        $reply = $guide->startTalk();
        $this->assertContains("您的输入不存在", $reply);
        
    }
    
    
    public function testCarSearch(){
        $userInput = "湘D99999";
        $guide = new Guide("oG24uwN10qZXaFm9KZLdeRj2inu0",$userInput);
        $reply = $guide->startTalk();
        $this->assertContains("您的输入不存在", $reply);
    }
    

    /**
     * Tests Guide->lastWaiter()
     */
    public function testLastWaiter()
    {

    }

    /**
     * Tests Guide->newWaiter()
     */
    public function testNewWaiter()
    {
        
    }
}

