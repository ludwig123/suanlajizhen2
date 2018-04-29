<?php
namespace app\index\model;

use think\Db;

define('TABLE_NAME', [
    '法' =>'law_fa',
    '办法' => 'law_banfa',
    '条例' => 'law_tiaoli',
    '机动车规定' => 'law_jidongcheguiding',
    '驾驶证规定' => 'law_jiashizhengguiding',
    '校车规定' => 'law_xiaocheguiding'
]);
class LawSearcher{

    public function  law($name, $index){
        $tableName = $this->table_name($name);
        if ($tableName)
             return $this->law_real($tableName, $index);
        else return "can't understand law name you input!";
    }
    
    
    private function law_real($tableName, $index)
    {
        $max = count_table_row($tableName);
        
        if ($index < 1) {return "index should >= 1";}
        
        if ($index > $max) {return "index should <= " . $max;}
        
        if ($index <= $max && $index >= 1) {
            $result = Db::name($tableName)->where('id', $index)->find();
            return $result;
        }
    }
    
    
    private function table_name($name)
    {
        switch ($name) {
            case "法":
            case "道交法":
                return TABLE_NAME['法'];
                
            case "办法":
            case "湖南实施办法":
                return TABLE_NAME['办法'];
                
                
            case "条例":
            case "湖南实施条例":
                return TABLE_NAME['条例'];
                
                
            case "机动车规定":
                return TABLE_NAME['机动车规定'];
                
                
            case "驾驶证规定":
                return TABLE_NAME['驾驶证规定'];
                
                
            case "校车规定":
                return TABLE_NAME['校车规定'];
                
            default:
                return false;
        }
    }
}