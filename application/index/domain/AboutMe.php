<?php


namespace app\index\domain;


use app\index\model\AboutMeModel;

class AboutMe
{
    public function queryCountFromStart($openId)
    {
        $model = new AboutMeModel();
        $count = $model->queryCount($openId);
        return $count;
    }

    public function queryCountThisYear($openId)
    {
        $currentYear = TimeHelper::currentYearStart();

        $model = new AboutMeModel();
        $count = $model->queryCountCurrentYear($openId, $currentYear);
        return $count;
    }

    public function firstMeet($openId)
    {
        $model = new AboutMeModel();
        return $model->firstMeet($openId);
    }

    public function aboutMe($openId)
    {
        $firstMeet = $this->firstMeet($openId);
        $totalCount = $this->queryCountFromStart($openId);
        $currentYearCount = $this->queryCountThisYear($openId);

        $average = $this->currentYearAvarage();

        $gameCount = round($totalCount * 3 / 20,1);
        $musicCount = $currentYearCount;

        $text = "您第一次遇见酸辣季真在".$firstMeet."从那一刻开始到今天您一共查询".$totalCount."次\n为您节省了".($totalCount*3)."分钟，可以让您多打".$gameCount."局王者农药\n
        今年您一共查询了".$currentYearCount."次，".$this->avarageText($average, $currentYearCount);

        return $text;

    }

    private function currentYearAvarage()
    {
        $currentYear = TimeHelper::currentYearStart();

        $model = new AboutMeModel();
        $count = $model->avarageCount($currentYear);
        return $count;
    }

    private function avarageText($average, $meCount)
    {
        if ($meCount < $average) return "低于人均次数".$average."次，代码本您背的越来越熟练了呢！";
        if ($meCount = $average) return "等于人均次数".$average."次，中庸之道，这会不会太巧了呢？";
        if ($meCount < $average) return "高于人均次数".$average."次，您在劳模路上奔驰，我们向你看齐！";

    }

}