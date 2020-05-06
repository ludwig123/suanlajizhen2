<?php


namespace app\index\model;


use app\index\domain\AboutMe;

class AboutMeWaiter implements Waiter
{
    private $openId;
    function __construct($openId)
    {
        $this->openId = $openId;
    }

    public function reply($input)
    {
        $me = new AboutMe();
        $text = $me->aboutMe($this->openId);
        return $text;
    }
}