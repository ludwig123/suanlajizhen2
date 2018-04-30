<?php
namespace app\index\model;

use app\index\model\Waiter;

class LawWaiter implements Waiter{
    
    public function reply($input)
    {
        return "i m law waiter!";
    }

    
    
}