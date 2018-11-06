<?php

class String
{
    /**
     * 截取字符串
     * @param string $string
     * @param int $length
     * @param string $dot
     * @return string
     */
    public static function cut($string, $length, $dot = '...')
    {
        //记载原始内容
        $oldString = $string;
        $string = str_replace(array('&nbsp;', '&amp;', '&quot;', '&#039;', '&ldquo;', '&rdquo;', '&mdash;', '&lt;', '&gt;', '&middot;', '&hellip;'), array(' ', '&', '"', "'", '“', '”', '—', '<', '>', '·', '…'), $string);
        $iActLength = (strlen($string)+mb_strlen($string,"UTF-8"))/2;
        if($iActLength <= $length) {
            return $oldString;
        }

        $n = $tn = $noc = 0;
        while($n < strlen($string)) {

            $t = ord($string[$n]);
            if($t == 9 || $t == 10 || (32 <= $t && $t <= 126)) {
                $tn = 1; $n++; $noc++;
            } elseif(194 <= $t && $t <= 223) {
                $tn = 2; $n += 2; $noc += 2;
            } elseif(224 <= $t && $t <= 239) {
                $tn = 3; $n += 3; $noc += 2;
            } elseif(240 <= $t && $t <= 247) {
                $tn = 4; $n += 4; $noc += 2;
            } elseif(248 <= $t && $t <= 251) {
                $tn = 5; $n += 5; $noc += 2;
            } elseif($t == 252 || $t == 253) {
                $tn = 6; $n += 6; $noc += 2;
            } else {
                $n++;
            }

            if($noc >= $length) {
                break;
            }

        }
        if($noc > $length) {
            $n -= $tn;
        }

        $strcut = substr($string, 0, $n);
        $strcut = str_replace(array('"', "'", '<', '>'), array('&quot;', '&#039;', '&lt;', '&gt;'), $strcut);
        if (!empty($dot)) {
            $dot = '<em style="font-size:12px;">'.$dot.'</em>';
        }
        return $strcut.$dot;
    }

    /**
     * 截取中文
     * @param string $string
     * @param string $sublen
     * @param int $start
     * @param string $code
     * @return string
     */
    public static function cutZh($string, $sublen, $start = 0, $code = 'UTF-8')
    {
        if ($code == 'UTF-8') {
            $pa = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|\xe0[\xa0-\xbf][\x80-\xbf]|[\xe1-\xef][\x80-\xbf][\x80-\xbf]|\xf0[\x90-\xbf][\x80-\xbf][\x80-\xbf]|[\xf1-\xf7][\x80-\xbf][\x80-\xbf][\x80-\xbf]/";
            preg_match_all($pa, $string, $t_string);

            if (count($t_string[0]) - $start > $sublen) {
                return join('', array_slice($t_string[0], $start, $sublen)) . "...";
            }

            return join('', array_slice($t_string[0], $start, $sublen));
        } else {
            $start = $start * 2;
            $sublen = $sublen * 2;
            $strlen = strlen($string);
            $tmpstr = '';

            for ($i = 0; $i < $strlen; $i++) {
                if ($i >= $start && $i < ($start + $sublen)) {
                    if (ord(substr($string, $i, 1)) > 129) {
                        $tmpstr .= substr($string, $i, 2);
                    } else {
                        $tmpstr .= substr($string, $i, 1);
                    }
                }
                if (ord(substr($string, $i, 1)) > 129) {
                    $i++;
                }

            }
            if (strlen($tmpstr) < $strlen) {
                $tmpstr .= "...";
            }

            return $tmpstr;
        }
    }

    /**
     * 随机固定长度字符串
     * @param int $length
     * @param int $type
     * @return string
     */
    public static function random($length = 30, $type = 0)
    {
        $type = abs($type);
        switch ($type) {
            case 1:
                $pool = '0123456789';
                break;
            case 2:
                $pool = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                break;
            default :
                $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                break;
        }
        return substr(str_shuffle(str_repeat($pool, $length)), 0, $length);
    }

    /**
     * utf8转gbk
     * @param string $str
     * @return string
     */
    public static function UTFToGBK($str)
    {
        return iconv("UTF-8", "GB2312//IGNORE", $str); // 这里将UTF-8转为GB2312编码
    }

    /**
     * 计算长度
     * @param string $str
     * @return int
     */
    public static function length($str)
    {
        $str = str_replace(
            array('&nbsp;', '&amp;', '&quot;', '&#039;', '&ldquo;', '&rdquo;', '&mdash;', '&lt;', '&gt;', '&middot;', '&hellip;'),
            array(' ', '&', '"', "'", '“', '”', '—', '<', '>', '·', '…'),
            $str
        );
        $iActLength = (strlen($str)+mb_strlen($str,"UTF-8"))/2;
        return $iActLength;
    }

    /**
     * @param string $str
     * @param string $salt
     * @return string
     */
    public static function sha256($str,$salt='pwoerqwelkasdpfouaidsvqweprouqwe')
    {
        return hash('sha256',$str . $salt);
    }

    /**
     * 检查字符串是否包含某个词汇
     * @param string $str
     * @param array|string $words
     * @return string
     */
    public static function has($str, $words) {
        foreach ((array) $words as $needle) {
            if ($needle !== '' && mb_strpos($str, $needle) !== false) {
                return true;
            }
        }

        return false;
    }
}