<?php

/**
 * LawSearcher test case.
 */
use app\index\model\LawSearcher;

class LawSearcherTest extends PHPUnit_Framework_TestCase
{

    /**
     *
     * @var LawSearcher
     */
    private $lawSearcher;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->lawSearcher = new LawSearcher(/* parameters */);
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        $this->lawSearcher = null;
        
        parent::tearDown();
    }

    /**
     * Constructs the test case.
     */
    public function __construct()
    {
        // TODO Auto-generated constructor
    }

 
    public function testLaw()
    {

    }

    public function testLaw_fa()
    {
        $index1 = 1;      
        $result =  $this->lawSearcher->law_fa($index1);
        $this->assertEquals(1, $result['id']);
        
        $index200 = "200";
        $result =  $this->lawSearcher->law_fa($index200);
        $this->assertContains("index should <=", $result);
        
        $indexless = -11;
        $result =  $this->lawSearcher->law_fa($indexless);
        $this->assertContains("index should >= 1", $result);
    }
}

