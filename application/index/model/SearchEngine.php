<?php
namespace app\index\model;

use think\Db;

class SearchEngine
{

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
    
    public function codeSearch($code){
        
    }

    private function count_table_row($name)
    {
        $result = db($name)->select();
        return count($result);
    }
    
    
    public function connectBus($chePai){
        
        $map ['车牌号'] = array('like', '%'.$chePai.'%');
        
        $temp = db( 'connect_bus' )->where ('车牌号', 'like', '%'.$chePai.'%')->select ();
        
        if ($temp == null){
            return $chePai."未查询到接驳信息";
        }
        
        $content = null;
        foreach ( $temp[0] as $k => $v ) {
            $content = $content . $k . '：' . $v . "\n";
        }
        
        return $content;
    }
}