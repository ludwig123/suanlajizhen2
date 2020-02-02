<?php
namespace app\index\model;


class CodeWaiter implements Waiter
{
    private $book;
    
    public function reply($input)
    {
        if (!Guide::isCodeSearch($input)){
            return null;
        }

       if ($result = $this->replyFromOldBook($input))
           return $result;

       return $this->replyFormNewBook($input);
    }

    private function replyFromOldBook($input)
    {
        if (is_numeric($input[0]) && !$this->isNewWaiter()  && ($this->book->existPage($input[0]))){
            return $this->book->goPage($input[0]);
        }
        return false;
    }

    private function replyFormNewBook($input)
    {
        $codeSearcher = new CodeSearcher();
        $this->book = $codeSearcher->getBook($input);
        return $this->book->goCatalog();
    }

    private function isNewWaiter()
    {
        return empty($this->book);
    }
}

