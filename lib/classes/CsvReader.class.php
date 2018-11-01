<?php
/**
 * Created by PhpStorm.
 * User: wangqiang
 * Date: 2018/9/4
 * Time: 12:03
 */
class CsvReader
{
    /**
     * 文件
     */
    private $file;

    private $spl_object;

    /**
     * 设置参数
     */
    public $params;

    /**
     * 导出数据
     */
    private $out;

    /**
     * 导出文件名
     */
    private $file_name;

    public function __construct($csv_file)
    {
        if ($csv_file && file_exists($csv_file)) {
            $this->file = $csv_file;
            $this->spl_object = new SplFileObject($csv_file);
        } else {
            throw new Exception('NOT FOUND FILE!');
        }
    }

    public function getFileLines()
    {
        $this->spl_object->seek($this->spl_object->getSize());
        return $this->spl_object->key();
    }

    public function readFile()
    {
        $cache = array();
        while (!$this->spl_object->eof()) {
            $row = $this->spl_object->fgetcsv();
            // $str = iconv('gbk', 'utf-8', implode(',', $this->spl_object->fgetcsv()));
            $row = eval('return ' . iconv('gbk', 'utf-8', var_export($row, true)) . ';');
            $cache[] = $row;
        }
        // array_shift($cache);
        // array_pop($cache);
        return count($cache);
    }

    public function fileGetContents($filename)
    {
        fopen($filename, "r");
        $excelData = array();
        $content = trim(file_get_contents($filename));
        $excelData = explode("\n", $content);

        // str_getcsv  解析 CSV 字符串为一个数组
        $resoure = [];
        foreach ($excelData as $value) {
            $string = mb_convert_encoding(trim(strip_tags($value)), 'utf-8', 'gbk');
            $v = explode(',', trim($string));
            $count = count($v);
            $row = [];
            for ($i = 0; $i < $count; $i++) {
                $row[] = $v[$i];
            }
            $resoure[] = $row;
        }
        return count($resoure);

        // return $excelData;
        $chunkData = array_chunk($excelData, 5000); // 将这个10W+ 的数组分割成5000一个的小数组。这样就一次批量插入5000条数据。mysql 是支持的。
        // $count = count($chunkData);
        // $data = [];
        // foreach($chunkData as $k => $chunk) {
        //     $resoure = [];
        //     foreach($chunk as $value){
        //         $string = mb_convert_encoding(trim(strip_tags($value)), 'utf-8', 'gbk');
        //         $v = explode(',', trim($string));
        //         $count = count($v);
        //         $row = [];
        //         for ($i=0; $i<$count;$i++) {
        //             $row[] = $v[$i];
        //         }
        //         $resoure[] = $row;
        //     }
        //     $data[] = $resoure;
        // }
        // return count($data);
    }

    public function export($keys, $data, $file_name = 'export.csv')
    {
        $this->file_name = $file_name;

        if (empty($data)) {
            return false;
        }
        $sOut = implode(',', $keys) . "\n";
        foreach ($data as $key => $value) {
            $temp = array();
            foreach ($keys as $k => $v) {
                $temp[] = $value[$k];
            }
            $sOut .= implode(',', $temp) . "\n";
        }
        $this->out = $sOut;
        $this->exportCsv();
    }

    public function exportCsv()
    {
        // $this->out = iconv('utf8', 'gbk', $this->out);
        // $this->file_name = iconv('utf8', 'gb2312', $this->file_name);
        $this->out = mb_convert_encoding($this->out, 'gb2312');
        // $this->file_name = mb_convert_encoding($this->file_name, 'gb2312');
        header("Content-type:application/vnd.ms-excel");
        header("Content-Disposition:filename=" . $this->file_name);
        echo $this->out;
    }

    public function test()
    {
        print_r($this->params);
    }
}
