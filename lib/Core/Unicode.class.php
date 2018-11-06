<?php
class Unicode 
{
    /**
     * 将内容进行UNICODE编码，编码后的内容格式：\u56fe\u7247
     * @param string $name
     * @return string
     */
    public static function encode($name)
    {
        $name = iconv('UTF-8', 'UCS-2', $name);
        $len = strlen($name);
        $str = '';
        for ($i = 0; $i < $len - 1; $i = $i + 2) {
            $c = $name[$i];
            $c2 = $name[$i + 1];
            if (ord($c) > 0) {
                // 两个字节的文字
                $str .= '\u'.base_convert(ord($c), 10, 16).base_convert(ord($c2), 10, 16);
            } else {
                $str .= $c2;
            }
        }
        return $str;
    }

    public static function decode($name)
    {
        // 转换编码，将Unicode编码转换成可以浏览的utf-8编码
        $pattern = '/([\w]+)|(\\\u([\w]{4}))/i';
        preg_match_all($pattern, $name, $matches);
        if (!empty($matches)) {
            $name = '';
            for ($j = 0; $j < count($matches[0]); $j++) {
                $str = $matches[0][$j];
                if (strpos($str, '\\u') === 0) {
                    $code = base_convert(substr($str, 2, 2), 16, 10);
                    $code2 = base_convert(substr($str, 4), 16, 10);
                    $c = chr($code).chr($code2);
                    $c = iconv('UCS-2', 'UTF-8', $c);
                    $name .= $c;
                } else {
                    $name .= $str;
                }
            }
        }
        return $name;
    }

    /**
     * 创建匿名函数 和 json_encode()中文不转义处理
     * @param string $str
     * @return string
     */
    public static function uEncode($str)
    {
        return preg_replace_callback('/\\\u([0-9a-f]{4})/i',
            create_function(
                '$matches',
                'return mb_convert_encoding(pack("H*", $matches[1]), "UTF-8", "UCS-2BE");'
            ),
            $str);
    }
}
