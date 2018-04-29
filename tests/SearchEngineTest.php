<?php
namespace tests;


use PHPUnit\Framework\TestCase;
use app\index\model\CodeSearcher;

class SearchEngineTest extends TestCase
{

    private $searchEngine;


    protected function setUp()
    {
        parent::setUp();
        
        // TODO Auto-generated SearchEngineTest::setUp()
        
        $this->searchEngine = new CodeSearcher(/* parameters */);
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


    public function __construct()
    {
        // TODO Auto-generated constructor
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
    
    public function testCodeSearch(){
        $code = '11110';
        $result = $this->searchEngine->codeSearch($code);
        var_dump($result);
        //返回的11110 是 float 格式！
        $this->assertEquals($code, $result[0]['违法代码']);
        
        $code = '11111';
        $result = $this->searchEngine->codeSearch($code);
        $this->assertEquals('11110', $result[0]['违法代码'], "应该返回11110的结果");
        
        $code = '10069';
        $result = $this->searchEngine->codeSearch($code);
        $this->assertEquals('10060', $result[0]['违法代码'], "应该返回10060的结果");
        $this->assertEquals(3, count($result));
    }
    
}

