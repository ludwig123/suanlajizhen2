<?php
namespace app\index\model;

use think\Db;
use phpDocumentor\Reflection\Types\Array_;

class CodeSearcher
{
    public function  law($name, $index){
        if ($this->is_fa()){
            return $this->law_fa($index);
        }
    }

    public function law_fa($index)
    {
        $max = $this->count_table_row("law_fa");
        
        if ($index < 1) {return "index should >= 1";} 
        
        if ($index > $max) {return "index should <= " . $max;}
        
        if ($index <= $max && $index >= 1) {
            $result = Db::name('law_fa')->where('id', $index)->find();
            return $result;
        }
    }
    
    /**用数字查询代码，自动纠错，依次删除最后一位数字，直到查询结果不为null
     * @param string $code
     * @return NULL|array
     */
    public function codeSearch($code){
        $result = null;
        while (($result = $this->codeOnlySearch($code)) == null){
            $code = $this->deleteLastdigit($code);
        }
        return $result;
    }
    
    public function textSearch($keyWord){
        
    }
    
    private function deleteLastdigit($code){
        return mb_substr($code,0,mb_strlen($code)-1);
    }
    
    /**精确的用数字查询代码 eg:11110
     * @param String $code
     * @return Array
     */
    public function codeOnlySearch($code){
        $result = db( 'daima2016' )->where ('违法代码', 'like', '%'.$code.'%')->field ( 'ID', TRUE )->select ();
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
}