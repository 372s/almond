<?php

class ExportCsv
{
    /**
     * 读取CSV文件
     * @param string $csv_file csv文件路径
     * @param int $lines       读取行数
     * @param int $offset      起始行数
     * @return array|bool
     */
    public static function read_csv_lines($csv_file = '', $lines = 0, $offset = 0)
    {
        if (!$fp = fopen($csv_file, 'r')) {
            return false;
        }
        $i = $j = 0;
        while (false !== ($line = fgets($fp))) {
            if ($i++ < $offset) {
                continue;
            }
            break;
        }
        $data = array();
        while (($j++ < $lines) && !feof($fp)) {
            $data[] = fgetcsv($fp);
        }
        fclose($fp);
        return $data;
    }

    /**
     * 导出CSV文件
     * @param array $data        数据
     * @param array $header_data 首行数据
     * @param string $file_name  文件名称
     * @return string
     */
    public static function export_csv_1($data = [], $header_data = [], $file_name = '')
    {
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . $file_name);
        if (!empty($header_data)) {
            echo iconv('utf-8', 'gbk//TRANSLIT', '"' . implode('","', $header_data) . '"' . "\n");
        }
        foreach ($data as $key => $value) {
            $output = array();
            $output[] = $value['id'];
            $output[] = $value['name'];
            echo iconv('utf-8', 'gbk//TRANSLIT', '"' . implode('","', $output) . "\"\n");
        }
    }

    /**
     * 导出CSV文件
     * @param array $data        数据
     * @param array $header_data 首行数据
     * @param string $file_name  文件名称
     * @return string
     */
    public static function export_csv_2($data = [], $header_data = [], $file_name = '')
    {
        if (!$file_name) {
            $file_name = date('Ymd_His') . '.csv';
        }
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename=' . $file_name);
        header('Cache-Control: max-age=0');
        $fp = fopen('php://output', 'a');
        if (!empty($header_data)) {
            foreach ($header_data as $key => $value) {
                $header_data[$key] = iconv('utf-8', 'gbk', $value);
            }
            fputcsv($fp, $header_data);
        }
        
        $count = count($data);
        if ($count > 0) {
            $num = 0;
            //每隔$limit行，刷新一下输出buffer，不要太大，也不要太小
            $limit = 100000;
            foreach ($data as $item) {
                $num++;
                //刷新一下输出buffer，防止由于数据过多造成问题
                if ($limit == $num) {
                    ob_flush();
                    flush();
                    $num = 0;
                }
                foreach ($item as $key => $value) {
                    $item[$key] = iconv('utf-8', 'gbk', $value);
                }
                fputcsv($fp, $item);
            }
        }
        fclose($fp);
    }

    public function export_excel($file_name, $data, $title = array())
    {
        header("Content-Type: application/vnd.ms-execl;charset=UTF-8");
        header("Content-Disposition: attachment;filename = {$file_name}.xls");
        header("Pragma: no-cache");
        header("Expires: 0");

        if (count($title)) {
            foreach ($title as $one) {
                echo mb_convert_encoding($one, "GB2312", "UTF-8") . "\t";
            }
            echo "\t\n"; // "\t"分割，"\n"换行
        }

        foreach ($data as $one_info) {
            foreach ($one_info as $one) {
                echo mb_convert_encoding($one, "GB2312", "UTF-8") . "\t";
            }
            echo "\t\n";
        }
    }
}
