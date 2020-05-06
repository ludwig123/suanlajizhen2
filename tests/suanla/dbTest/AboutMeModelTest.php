<?php


use app\index\model\AboutMeModel;

class AboutMeModelTest extends \think\testing\TestCase
{

    public function testQueryCount()
    {
        $model = new AboutMeModel();
        $count = $model->queryCount('oG24uwA-DtWeyAH-UIjzMN7pdQ7A');
        $this->assertGreaterThan(200,$count);
    }

    public function testFirsrMeet()
    {
        $model = new AboutMeModel();
        $count = $model->firstMeet('oG24uwA-DtWeyAH-UIjzMN7pdQ7A');
        $this->assertContains('星期',$count);
    }

    public function testAvarageCount()
    {
        $model = new AboutMeModel();
        $currentYear = \app\index\domain\TimeHelper::currentYearStart();
        $count = $model->avarageCount($currentYear);
        $this->assertGreaterThan(1,$count);
    }
}
