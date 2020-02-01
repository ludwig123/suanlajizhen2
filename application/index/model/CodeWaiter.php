<?php
namespace app\index\model;


class CodeWaiter implements Waiter
{
    private $book;
    private $serviceType = "code";
    
    public function reply($input)
    {
        if (!Guide::isCodeSearch($input)){
            return null;
        }
        
        if (is_numeric($input[0]) && $this->book != null  && ($this->book->existPage($input[0]))){
            $this->serviceType = 'code-toPage';
            return $this->book->goPage($input[0]);
        }
        
        $codeSearcher = new CodeSearcher();
        $this->book = $codeSearcher->getBook($input);
        $this->serviceType = 'code-search';
        return $this->book->goCatalog();
           
    }
}

