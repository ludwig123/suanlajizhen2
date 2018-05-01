<?php

/**
 * Tokenizer test case.
 */
use app\index\model\Tokenizer;

class TokenizerTest extends PHPUnit_Framework_TestCase
{

    /**
     *
     * @var Tokenizer
     */
    private $tokenizer;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();
        
        // TODO Auto-generated TokenizerTest::setUp()
        
        $this->tokenizer = new Tokenizer(/* parameters */);
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        // TODO Auto-generated TokenizerTest::tearDown()
        $this->tokenizer = null;
        
        parent::tearDown();
    }

    /**
     * Constructs the test case.
     */
    public function __construct()
    {
        // TODO Auto-generated constructor
    }

    public function testCodeSplit()
    {
        $text = "傻逼驾驶证";
       $result =  $this->tokenizer->split($text);
       $this->assertEquals("驾驶证", $result[0]);
       
       $text = "*_=/驾驶驾驶证我逾期";
       $result =  $this->tokenizer->split($text);
       var_dump($result);
       $this->assertEquals("驾驶", $result[0]);
       $this->assertContains("逾期",$result[2]);
    }
    
    public function testLawInputSplit(){
        $text = "法15条";
        $result =  $this->tokenizer->split($text);

        $this->assertEquals("法", $result[0]);
        
        
        $text = "道交法 12 条";
        $result =  $this->tokenizer->split($text);
        var_dump($result);
        $this->assertEquals("道交法", $result[0]);
        
        
        $text = "条例25条";
        $result =  $this->tokenizer->split($text);
        $this->assertEquals("条例", $result[0]);
    }

}

