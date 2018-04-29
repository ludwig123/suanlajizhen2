<?php
namespace app\index\model;

use think\Db;

class LawSearcher{
    
    public function  law($name, $index){
        if ($this->is_fa()){
            return $this->law_fa($index);
        }
    }
    
    
    public function law_fa($index)
    {
        $max = count_table_row("law_fa");
        
        if ($index < 1) {return "index should >= 1";}
        
        if ($index > $max) {return "index should <= " . $max;}
        
        if ($index <= $max && $index >= 1) {
            $result = Db::name('law_fa')->where('id', $index)->find();
            return $result;
        }
    }
    
    private function is_fa($name)
    {
        switch ($name) {
            case "法":
            case "道交法":
                return true;
                
            default:
                return false;
        }
    }
}