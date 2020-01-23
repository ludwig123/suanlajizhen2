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

    public function testUrlDict_works()
    {
        $result = (new Liangguai())->url('10010');
        $this->assertNotEmpty($result);

    }
}
