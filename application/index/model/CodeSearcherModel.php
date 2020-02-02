<?php


namespace app\index\model;


use think\Exception;

class CodeSearcherModel
{
    /**用数字查询代码，自动纠错，依次删除最后一位数字，直到查询结果不为null
     * @param string $code
     * @return NULL|array
     */
    public function codeSearch($code){
        $result = null;

        while (($result = $this->codeOnlySearch($code)) == null){
            $code = $this->deleteLastChar($code);
        }
        return $result;
    }

    /**精确的用数字查询代码 eg:11110
     * @param String $code
     * @return Array
     */
    public function codeOnlySearch($code){
        try{
            $result = db( 'daima2016' )->where ('违法代码', 'like', '%'.$code.'%')->field ( 'ID', TRUE )->select ();
        }
        catch (Exception $exception){
            $this->dbErroTips($exception);
        }

        return $result;
    }

    public function searchByWordArray($wordArr)
    {
        $map = $this->createMap($wordArr);
        $result = $this->search($map);
        if ($result == []){
            $result = $this->searchOr($map);
        }
        return $result;
    }

    private function search($map)
    {
        try
        {
            return db('daima2016')->whereOr($map)->select();
        }
        catch (Exception $exception)
        {
            $this->dbErroTips($exception);
        }
    }

    private function searchOr($map)
    {
        try
        {
        return db('daima2016')->where($map)->select();
        }
        catch (Exception $exception)
        {
            $this->dbErroTips($exception);
        }
    }


    public function createMap($input){
        $map = [];
        foreach ((array)$input as $k => $word){
            if ($this->isCode($word)){
                $map[] = ['违法代码','like', '%'.$word.'%'];
                continue;
            }
            if ($this->isText($word)){
                $map[] = ['违法内容', 'like', '%'.$word.'%'];
                continue;
            }
            if ($this->isMoney($word)){
                $map[] = ['罚款金额', 'like', $this->deleteLastChar($word)];
                continue;
            }
            if ($this->isScore($word)){
                $map[] = ['违法记分', 'like', $this->deleteLastChar($word)];
                continue;
            }
        }
        return $map;
    }

    private function deleteLastChar($str){
        return mb_substr($str,0,mb_strlen($str)-1);
    }

    private function isCode($word){
        $pattern = '/^[0-9]{1,}$/u';
        return isMatch($pattern, $word);
    }

    private function isMoney($word){
        $pattern = '/^[0-9]{1,}元$/u';
        return isMatch($pattern, $word);
    }

    private function isScore($word){
        $pattern = '/^[0-9]{1,}分$/u';
        return isMatch($pattern, $word);
    }

    private function isText($word){
        $pattern = '/^[\x{4e00}-\x{9fa5}$]{1,}/u';
        return isMatch($pattern, $word);
    }

    private function dbErroTips($e)
    {
        echo('something wrong with db operation in'.__FILE__.'at line '.__LINE__);
        var_dump($e);
    }

    public function searchByAlias($input)
    {
        $words = preg_split('//u',$input,-1, PREG_SPLIT_NO_EMPTY);
        if (count($words) < 2) return [];
        $word = '';
        foreach ($words as $k => $v)
        {
            $word .= '%'.$v;
        }
        $word .= '%';

        return db('weifa_alias')->where('alias', 'like', $word)->select();

    }

}