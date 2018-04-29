<?php
namespace tests;

use app\index\model\SearchEngine;
use PHPUnit\Framework\TestCase;

class SearchEngineTest extends TestCase
{

    private $searchEngine;


    protected function setUp()
    {
        parent::setUp();
        
        // TODO Auto-generated SearchEngineTest::setUp()
        
        $this->searchEngine = new SearchEngine(/* parameters */);
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        // TODO Auto-generated SearchEngineTest::tearDown()
        $this->searchEngine = null;
        
        parent::tearDown();
    }

    /**
     * Constructs the test case.
     */
    public function __construct()
    {
        // TODO Auto-generated constructor
    }

    
    public function testLaw_fa()
    {
        $index1 = "1";
        
       $result =  $this->searchEngine->law_fa($index1);
       var_dump($result);
//         $this->assertNull("000","不应该是空的");
        $this->assertEquals(1, $result['id']);
        
        $index200 = "200";
        $result =  $this->searchEngine->law_fa($index200);
        $this->assertNull($result);
        
    }
}

