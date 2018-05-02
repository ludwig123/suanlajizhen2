<?php
namespace app\index\model;


class CodeWaiter implements Waiter
{
    private $book;
    public function reply($input)
    {
        
        if ($this->book != null  && ($input[0] < $this->book->maxPageNumber())){
            return $book->goPage($input[0]);
        }
        
        $codeSearcher = new CodeSearcher();
        $this->book = $codeSearcher->getBook($input);
        
        return $book->goCatalog;
           
    }
    

}

