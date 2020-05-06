<?php


namespace app\index\domain;


class TimeHelper
{
    public static function currentYearStart()
    {
        $t = time();
        $year = mktime(0,0,0,1,1,date("Y",$t));
        return date("Y",$year);
    }

}