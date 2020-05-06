<?php


use app\index\model\Guide;
use PHPUnit\Framework\TestCase;

class GuideTest extends TestCase
{

    public function testStartTalk()
    {
        $guide = new Guide('oG24uwNMmFS-epZJxD9X3jwgerC4', '我');
        $reply = $guide->startTalk();
        $this->assertStringContainsString('王者农药', $reply);

    }
}
