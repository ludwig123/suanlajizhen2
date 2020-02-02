<?php


use app\index\model\CodeSearcherModel;
use PHPUnit\Framework\TestCase;

class CodeSearcherModelTest extends TestCase
{

    public function testSearchByAlias_default()
    {
        $model = new  CodeSearcherModel();
        $result = $model->searchByAlias('超速');
        $this->assertNotEmpty($result);
    }

    public function testSearchByAlias_part_keyword()
    {
        $model = new  CodeSearcherModel();
        $result = $model->searchByAlias('违停');
        $this->assertNotEmpty($result);
    }

    public function testSearchByAlias_one_word_return_empty()
    {
        $model = new  CodeSearcherModel();
        $result = $model->searchByAlias('超');
        $this->assertEmpty($result);
    }
}
