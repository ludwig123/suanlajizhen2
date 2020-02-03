<?php


namespace app\index\model;


use app\index\domain\Liangguai;

class MyBook2
{
    const PAGE_SIZE = 1900;
    private $book, $rearrange;

    /** 自动根据输入类型，构建书本
     * MyBook2 constructor.
     * @param string|array $draft
     */
    public function __construct($draft = '', $rearrange = false)
    {
        if (Empty($draft))
        {
            $this->book = [];
            return;
        }

        if (is_string($draft))
        {
            $this->book = $this->textToBook($draft);
        }
        else if (is_array($draft))
        {
            $this->book = $this->arrayToBook($draft, $rearrange);
        }
        return;
    }

    /** 翻到指定页面
     * @param $index
     * @return string
     */
    public function page($index){
        return $this->book[$index];
    }

    /** 目录
     * @return string
     */
    public function catalog(){
        return $this->book[0];
    }

    public function maxPageNumber(){
        return count($this->book);
    }

    public function existPage($pageNum)
    {
        return array_key_exists($pageNum, $this->book);
    }

    private function pageNumberSequence($now, $sum) {
        $result = '';
        switch ($now) {
            case 1 :
                $char = "①";
                break;

            case 2 :
                $char = "②";
                break;

            case 3 :
                $char = "③";
                break;

            case 4 :
                $char = "④";
                break;

            case 5 :
                $char = "⑤";
                break;

            case 6 :
                $char = "⑥";
                break;
            case 7 :
                $char = "⑦";
                break;

            case 8 :
                $char = "⑧";
                break;

            case 9 :
                $char = "⑨";
                break;

            case 10 :
                $char = "⑩";
                break;
        }
        for ($i=1 ; $i<= $sum && $i <= 10;$i++){
            if ($i == $now){
                $result .= $char." ";
            }
            else $result .= $i." ";
        }
        return $result;
    }

    /**
     * @param array $draft 数组形式的字符串
     * @param boolean  $rearrange true 重排 false 不重排(默认)
     * @return array
     */
    public function arrayToBook($draft, $rearrange = false)
    {
        if ($rearrange)
        {
            $draft = $this->compressPages($draft);
        }
        return $this->addFooter($draft);
    }

    /** 把字符串转成一本书，保留符号和换行标记
     * @param $text
     * @return array
     */
    public function textToBook($text)
    {
        $draftBook =  $this->spiltTextIntoArray($text);
        return $this->addFooter($draftBook);
    }

    /** 把文本串分割为指定大小的数字，便于分页
     * @param $text
     * @return array
     */
    private function spiltTextIntoArray($text)
    {
        if (!is_string($text) || empty($text) )
            return [];

        $textArr = preg_split('/([\\n，。])/u',$text,-1,PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);

        return $this->compressPages($textArr);
    }

    /** 添加页码
     * @param array $draftBook
     * @return array $book 完整的书本
     */
    public function addFooter($draftBook)
    {
        $sum = count($draftBook);
        foreach ($draftBook as $k => $v)
        {
            $v .= "请输入数字翻页:\n\n第".$this->pageNumberSequence($k, $sum)."页";
            $book[] = $v;
        }
        return $book;
    }

    /** 使每一页都尽量填满,以便压缩书本厚度
     * @param array $rawDraft
     * @return array $reulst 压缩完成的初稿
     */
    public function compressPages($rawDraft)
    {
        $countRawDraft = count($rawDraft);
        $result = [];
        $i = $j = 0;
        for (; $j != $countRawDraft ; $i++)
        {
            $temp = '';
            for (; $j < $countRawDraft;$j++)
            {
                $result[$i] = $temp;
                $temp .= $rawDraft[$j];
                if (strlen($temp) > self::PAGE_SIZE )
                {
                    break; //尝试合并列表失败，本次合并结束，j指针不动
                }
            }
        }
        return $result;

    }

}