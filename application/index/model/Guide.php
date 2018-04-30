<?php
namespace app\index\model;

use app\index\model\Tokenizer;

/**导购员
 * @author ludwig
 *
 */
class Guide
{
    private $userID, $input;
        /**
     * @param String $userID 用户ID
     * @param String $rawInput 用户的消息
     */
    public function __construct($userID, $rawInput)
    {
        $this->userID = $userID;
        
        $tokenizer = new Tokenizer();
        $this->input = $tokenizer->split($rawInput);
        
    }

    public function startTalk(){
        
        if (count($this->input) == 0) return "您的输入不存在！";
        
        $waiter = $this->lastWaiter();
        if ($waiter == null){
            $waiter = $this->newWaiter();
        }
        
       return $waiter->reply($this->input);
        
    }
    
    public function lastWaiter(){
        $waiter = cache($this->userID);
        return $waiter;
    }
    
    public function newWaiter(){
        if ($this->isCarSearch()){
            return new BusWaiter();
        }
        return new LawWaiter($this->input);
    }
    
    private function isCarSearch(){
        $dictstr = "京 津 沪 渝 蒙 新 藏 宁 桂 港 澳 黑 吉 辽 晋 冀 青 鲁 豫 苏 皖 浙 闽 赣 湘 鄂 粤 琼 甘 陕 贵 川 云";
        $dictArr = explode(" ", $dictstr);
        foreach ($dictArr as $v){
            if ($v == $this->input[0])
                return true;
        } 
        return false;
    }
    
    private function isLawSearch(){
        
    }
    
    private function isCodeSearch(){
        
    }
}

