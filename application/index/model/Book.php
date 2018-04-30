<?php
namespace app\index\model;

class Book
{
    private $book;

    public function __construct()
    {
        $this->book = null;
    }
    
    public function page($index){
        return $this->book[$index];
    }
    
    public function max_page_number(){
        return count($this->book);
    }
    
    public function setLawBook($arr){
        
    }
    
    public function setCodeBook($arr){
        
    }
}

