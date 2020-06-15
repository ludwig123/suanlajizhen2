<?php


namespace app\index\domain;

/*
 *  对接公众号两拐的内容
 */

use think\facade\Cache;

class Liangguai
{
    private $srcUrl = 'https://mp.weixin.qq.com/s?__biz=MzU3Mjc1ODc1NA==&mid=2247499401&idx=1&sn=72e9a2f88e60409ea26b633881909666&chksm=fcceb104cbb93812c4c8d840b36127503aa568e4d209ae1bf3da6d1ecf9421994580e6a35688&scene=126&sessionid=1579416934&key=6f12e37fb13e98175bd840c1a79717dfa9f874f33390065e42fe820955846a54d0773f2527f8af31f9a9ce2d74e3db082a529d6fc25d12d81a478b0adbfa4e1d8a17b49ce000a308a6b0f07bbb37bc7d&ascene=1&uin=ODU1MjMxODU%3D&devicetype=Windows+10&version=6208006f&lang=zh_CN&exportkey=A%2FqOrOu5IszGLTd%2BAJDN2no%3D&pass_ticket=bNQ52gysdZEi%2FGhWUVSYlP4bkJnlOK%2BWScCK2eo3Ymg%3D';

    private $urlDict = [];
    
    function __construct()
    {
        $this->initUrlDict();
    }

    /** 通过代码获取网址
     * @param $code
     * @return mixed
     */
    public function url($code)
    {
        if (array_key_exists($code, $this->urlDict))
            return $this->urlDict[$code];
        return '';
    }



    public function getHtmlPage()
    {
        $text = NetWorker::curl_get($this->srcUrl);
        if (empty($text))
            exit();

        return $text;
    }

    /**
     * 从原始网页中提取代码和对应的两拐地址
     * @param $text
     */
    public function makeUrlDictFromHtmlPage($text)
    {
        $pattern = '/(https:\/\/[^\s]*redirect)[\s\S]*?((?<=>)\d{5,5})/u';
        preg_match_all($pattern,$text,$matches);
        if (empty($matches))
        {
            echo '网页内没有想要的数据';
            exit();
        }

        if (!array_key_exists(1, $matches) || empty($matches[1]))
        {
            echo '没有网址数据';
            exit();
        }
        if (!array_key_exists(2, $matches) || empty($matches[2]))
        {
            echo '没有对应代码';
            exit();
        }

        $destUrls = $matches[1];
        $codes = $matches[2];

        if (count($destUrls) != ($length = count($codes)))
        {
            echo '网址数据和代码没有一一对应！';
            exit();
        }

        for ($i = 0; $i < $length; $i++)
        {
            $this->urlDict[$codes[$i]] = $destUrls[$i];
        }
    }
    
    private function initUrlDict()
    {
        $this->urlDict = Cache::get('urlDict');
        if (empty($this->urlDict))
        {
            $this->makeUrlDict();
            Cache::set('urlDict', $this->urlDict, 86400); //缓存以秒为单位
        }
    }

    /**
     * 制作词典
     */
    private function makeUrlDict()
    {
        $text = $this->getHtmlPage();
        $this->makeUrlDictFromHtmlPage($text);
    }
}