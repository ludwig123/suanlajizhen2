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

    public function testSplit()
    {
        $text = "傻逼驾驶证";
       $result =  $this->tokenizer->split($text);
       var_dump($result);
       $this->assertEquals("驾驶证", $result[0]);
       
       $text = "驾驶驾驶证超过";
       $result =  $this->tokenizer->split($text);
       var_dump($result);
       $this->assertEquals("驾驶", $result[0]);
       $this->assertContains("超过",$result[2]);
    }

}

