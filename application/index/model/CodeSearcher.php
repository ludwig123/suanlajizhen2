<?php
namespace app\index\model;

use think\Exception;

class CodeSearcher
{
    public function getBook($input){
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
    public function search($input){
        if (is_numeric($input[0]) && count($input) == 1)
            return $this->codeSearch($input[0]);
        
        $map = $this->createMap($input);
        $result = db('daima2016')->where($map)->select();
        if ($result == []){
            $result = db('daima2016')->whereOr($map)->select();
        }
        return $result;
    }
    
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
    
    public function textSearch($code){
        $result = null;
        while (($result = $this->codeOnlySearch($code)) == null){
            $code = $this->deleteLastChar($code);
        }
        return $result;
    }
    
    
    public function textSearchOR($code){
        $result = null;
        while (($result = $this->codeOnlySearch($code)) == null){
            $code = $this->deleteLastChar($code);
        }
        return $result;
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
    
    /**精确的用数字查询代码 eg:11110
     * @param String $code
     * @return Array
     */
    public function codeOnlySearch($code){
        try{
            $result = db( 'daima2016' )->where ('违法代码', 'like', '%'.$code.'%')->field ( 'ID', TRUE )->select ();
        }
        catch (Exception $e){
            var_dump($e);
        }

        return $result;
    }

    
    public function connectBus($chePai){
        
        $map ['车牌号'] = array('like', '%'.$chePai.'%');
        
        $temp = db( 'connect_bus' )->where ('车牌号', 'like', '%'.$chePai.'%')->select ();
        
        if ($temp == null){return $chePai."未查询到接驳信息";}
        
        $content = null;
        foreach ( $temp[0] as $k => $v ) {
            $content = $content . $k . '：' . $v . "\n";
        }
        
        return $content;
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
    
}