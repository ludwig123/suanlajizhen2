<?php
namespace app\index\model;


class LawWaiter implements Waiter{
    
    public function reply($input)
    {
        if (!Guide::isLawSearch($input)){
            return null;
        }
        $lawName = $input[0];
        $lawIndex = $input[1];
        $lawSearcher = new LawSearcher();
        
        return $lawSearcher->law($lawName, $lawIndex);
    }


    
    
}