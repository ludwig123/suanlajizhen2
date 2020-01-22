<?php


use app\index\domain\Liangguai;
use PHPUnit\Framework\TestCase;

class LiangguaiTest extends TestCase
{

    public function testGetRawPage()
    {
        $result = (new Liangguai())->getHtmlPage();
        $this->assertNotEmpty($result);

    }
}
