<?php
namespace app\index\model;

use think\Exception;

class CodeSearcher
{
    public function getBook($input)
    {
        return new MyBook($this->search($input));
    }

    /**
     *  通过关键词搜索代码表
     * @param $input
     * @return array|NULL|\PDOStatement|string|\think\Collection  数据库结果的游标
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function search($input)
    {
        $model = new CodeSearcherModel();
        if ($this->OneDigitArray($input))
            return $model->codeSearch($input[0]);

        return $model->searchByWordArray($input);
    }

    private function OneDigitArray($input)
    {
        if (is_numeric($input[0]) && count($input) == 1) return true;
        return false;
    }
}