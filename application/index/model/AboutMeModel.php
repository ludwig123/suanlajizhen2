<?php


namespace app\index\model;


use think\Db;

class AboutMeModel
{
    private $table = 'wp_weixin_text_message';

    public function queryCount($openId, $from = null, $end = null)
    {
        $map['FromUserName'] = ['=', $openId];
        if (!empty($from)) {
            $map['Time'] = ['like', '%'.$from.'%'];
        }
        if (!empty($end)) {
            $map['Time'] = ['<', $end];
        }

        return Db::table($this->table)
            ->where($map)
            ->count('FromUserName');
    }

    public function queryCountCurrentYear($openId, $from = null, $end = null)
    {
        return Db::table($this->table)
            ->where('FromUserName','=', $openId)
            ->where('Time','like', $from.'%')
            ->count('FromUserName');
    }

    public function firstMeet($openId)
    {
        $map['FromUserName'] = $openId;
        $first = Db::table($this->table)
            ->where($map)
            ->order('id')
            ->limit(1)
            ->select();

        return $first[0]['Time'];
    }

    public function avarageCount($from = null, $end = null)
    {
        $count = $this->queryCountAll($from, $end);
        $peopleCount = $this->queryPeopleCount($from, $end);
        return round($count / $peopleCount, 1);
    }

    public function queryCountAll($from = null, $end = null)
    {

        return Db::table($this->table)
            ->where('Time','like', $from.'%')
            ->count('FromUserName');
    }

    public function queryPeopleCount($from = null, $end = null)
    {

        return Db::table($this->table)
            ->field('FromUserName, count(FromUserName)')
            ->group('FromUserName')
            ->where('Time','like', $from.'%')
            ->count();
    }

}