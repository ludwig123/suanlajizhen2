<?php
namespace app\index\model;

use think\Db;

class SearchEngine{
    public function law_fa($index){
       $result =  Db::name('law_fa')->where('id',$index)->find();
       if ($result == NULL){
           return "";
       }
       return $result;
    }
    
    private function law_count(){
        
    }
}