<?php
namespace app\index\model;


class LawWaiter implements Waiter{
    
    public function reply($input)
    {
        $lawName = $input[0];
        $lawIndex = $input[1];
        $lawSearcher = new LawSearcher();
        
        return $lawSearcher->law($lawName, $lawIndex);
    }

    
    
}