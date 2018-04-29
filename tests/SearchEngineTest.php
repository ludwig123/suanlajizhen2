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
        $index1 = 1;
        
       $result =  $this->searchEngine->law_fa($index1);
//        var_dump($result);
//         $this->assertNull("000","不应该是空的");
        $this->assertEquals(1, $result['id']);
        
        $index200 = "200";
        $result =  $this->searchEngine->law_fa($index200);
        $this->assertContains("index should <=", $result);
        
        $indexless = -11;
        $result =  $this->searchEngine->law_fa($indexless);
        $this->assertContains("index should >= 1", $result);
        
    }
    
    public function testConnectBusFind(){
        $chePai = "川C19485";
        $result = $this->searchEngine->connectBus($chePai);
        $this->assertContains($chePai, $result);
        
        
    }
    
    public function testConnecBusNotFind(){
        $chePai = "湘D99999";
        $result = $this->searchEngine->connectBus($chePai);
        $this->assertContains("未查询到接驳信息", $result);
    }
    
    
}

