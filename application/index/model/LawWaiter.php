<?php
namespace app\index\model;

use app\index\model\Waiter;

class LawWaiter implements Waiter{
    
    public function reply($input)
    {
        var_dump($input);
        return "i m law waiter!";
    }

    
    
}