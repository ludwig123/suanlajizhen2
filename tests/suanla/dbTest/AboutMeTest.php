<?php


use app\index\domain\AboutMe;
use PHPUnit\Framework\TestCase;

class AboutMeTest extends TestCase
{

    public function testQueryCountThisYear()
    {
        $model = new AboutMe();
        $count = $model->queryCountThisYear('oG24uwNMmFS-epZJxD9X3jwgerC4');
        $this->assertGreaterThan(1,$count);
    }


    public function testAboutMe()
    {
        $model = new AboutMe();
        $count = $model->aboutMe('oG24uwNMmFS-epZJxD9X3jwgerC4');
        //@fixme 断言错了
        $this->assertGreaterThan(1,$count);
    }
}
