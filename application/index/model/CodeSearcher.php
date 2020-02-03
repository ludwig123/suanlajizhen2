<?php
namespace app\index\model;

use app\index\domain\Liangguai;
use think\Exception;

class CodeSearcher
{
    public function getBook($input)
    {
        $cursor = $this->search($input);
        return new MyBook($cursor);
    }

    /**
     *  通过关键词搜索代码表
     * @param $input
     * @return array|NULL|\PDOStatement|string|\think\Collection  数据库结果的游标
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function search($input)
    {
        $model = new CodeSearcherModel();
        if ($this->arrayWithOneDigit($input))
            return $model->codeSearch($input[0]);

        return $model->searchByWordArray($input);
    }

    private function arrayWithOneDigit($input)
    {
        if (is_numeric($input[0]) && count($input) == 1) return true;
        return false;
    }


    public function replyDetail($result) {
        $countResult = count($result);
        $content = '';
        foreach ( $result as $item => $date ) {
            foreach ( $date as $k => $v ) {
                if (! is_numeric ( $v ))
                    $v = trim ( $v );
                if (! empty ( $v )) {
                    $content = $content . $k . '：' . $v . "\n";
                }
            }
            $content = $content . "\n";

            //如果超出MAXLEN字节就返回,进入replyShort
            $len = $this->lenCount($content);
            if ($len > MAXLEN)
                return $this->replyShort($result);
        }

        //如果只有一条结果
        if ($countResult == 1){
            $pages = $this->getLawPages($content);
            $content .= "查询到" . $countResult . "条记录\n输入对应数字可查看详细内容：\n"
                . $this->genrateLawChoice($content) ;

            $code = ''.$result[0]['违法代码'];
            $liangGuaiUrl = (new Liangguai())->url($code);
            if (!empty($liangGuaiUrl))
            {
                $content .= '9:代码释义(公众号:两拐，提供支持)';
                $book = [$content];
                $finalBook = array_merge($book, $pages);
                $finalBook[9] = $liangGuaiUrl;
            }
            else
            {
                $book = [$content];
                $finalBook = array_merge($book, $pages);
            }
            return $finalBook;
        }
        else {
            $content = $content . "查询到" . $countResult . "条记录\n" ;
            return [$content];
        }
    }

    /**仅回复代码，违法内容
     * @param array $result 游标
     * @return string
     */
    public function replyShort($result) {
        $i = 0;
        $book = [];
        $content = '';
        foreach ( $result as $item => $date ) {
            $len = $this->lenCount($content);
            if ($len > MAXLEN)
                break;

            $content = $content . "代码：" . $date['违法代码'] . "\n内容：" . $date['违法内容'] . "\n\n";
            $i++;
        }

        //因为超出maxlen 跳出循环，or 数组循环完毕
        //数组循环完毕
        if ($i == count($result)){
            $content = $content . "查询到" . count ( $result ) . "条记录，请输入代码查看详情\n";
            $book[] = $content;
        }
        //超出一页的长度
        else {
            $pages = $this->splitPages($result);
            $sum = count($pages);

            //book[0] 目录页
            $book[] = $pages[1] . "查询到" . count ( $result ) . "条记录\n";


            foreach ($pages as $k=>$v){
                $book[] = $v . "查询到" . count ( $result ) . "条记录\n";
            }
        }
        return $book;
    }

    /**把分页的结果存储在以1开始的array中
     * @param array $result
     * @return mixed
     */
    private function splitPages($result){
        $pages = array(	);
        $i = 1;
        $content = '';
        foreach ( $result as $item => $data ) {

            $len = $this->lenCount($content);
            if ($len > MAXLEN){
                $pages[$i]= $content ;
                $i++;
                $content = null;
            }

            $content = $content . "代码：" . $data ['违法代码'] . "\n内容：" . $data ['违法内容'] . "\n\n";

        }

        //最后一页
        $pages[$i]= $content ;

        return $pages;
    }

    public function getLawPages($content){
        $laws = $this->getLaws($content);
        $tokenizer = new Tokenizer();
        $lawSearcher = new LawSearcher();
        $book = [];
        foreach ($laws as $singleLaw){
            $law = $tokenizer->split($singleLaw[0]);
            $index = $tokenizer->split($singleLaw[1]);

            $book[] = $lawSearcher->law($law[0], $index[0]);
        }

        return $book;
    }

    /** 从违则和罚则中生成数字排序的选项
     * @param $text
     * @return string
     */
    private function genrateLawChoice($text){
        $temp = $this->getLaws($text);
        $content = '';
        $i = 1;
        foreach ($temp as $t){
            //1:《法》48条;
            $content = $content . $i.":".$t[0] .$t[1].";\n";
            $i++;
        }
        return $content;
    }

    /**输入字符串，返回以数组形式组成的法律和条文。
     * @param string $text
     * @return array array[$i][0] == 《法》 array[$i][1] == 90  （条）
     */
    public function getLaws($text) {
        $result4law = $result = null;
        preg_match_all ( '/《[^《]*条/u', $text, $result4law );
        $law = $result4law [0];
        //	var_dump ( $result4law );
        $i = 0;
        foreach ( $law as $v ) {
            preg_match_all ( '/《\S*?》/u', $v, $k1 );
            $k1 = $k1 [0];
            //		var_dump ( $k1 );
            foreach ($k1 as $k11){
                preg_match_all ( '/\d{1,3}条/u', $v, $k2 );
                $k2 = $k2 [0];
                //			var_dump ( $k2 );
                foreach ( $k2 as $k21 ) {
                    $j = 0;
                    $result [$i][0] = $k11;
                    $result [$i][1] = $k21;
                    $j ++;
                    $i ++;
                }
            }
        }
        return $result;
    }

    private function lenCount($content){
        return strlen($content);
    }
}