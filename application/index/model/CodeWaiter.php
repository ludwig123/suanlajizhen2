<?php
namespace app\index\model;

use app\index\model\Waiter;

class CodeWaiter implements Waiter
{
    public function reply($input)
    {
        $order = array();
            $order['code'] = '';
            $order['text'] = '';
            $order['money'] = '';
            $order['score'] = '';
            
        foreach ($input as $word){
            if ($this->isCode($word)){
                $order['code'] = $word;
                break;
            }
            if ($this->isText($word)){
                $order['text'] = $word;
                break;
            }
            if ($this->isMoney($word)){
                $order['money'] = $word;
                break;
            }
            if ($this->isScore($word)){
                $order['score'] = $word;
                break;
            }
        }
        
        $codeSearcher = new CodeSearcher();
        $codeSearcher->codeSearch($order);
        
        
        
    }
    
    public function isCode($word){
        $pattern = '/^[0-9]{1,}$/u';
        return isMatch($pattern, $word);
    }
    
    public function isMoney($word){
        $pattern = '/^[0-9]{1,}元$/u';
        return isMatch($pattern, $word);
    }
    
    public function isScore($word){
        $pattern = '/^[0-9]{1,}分$/u';
        return isMatch($pattern, $word);
    }
    
    public function isText($word){
        $pattern = '/^[\u4e00-\u9fa5]{1,}$/u';
        return isMatch($pattern, $word);
    }

}

