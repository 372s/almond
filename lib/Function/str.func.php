<?php

if (!function_exists('cut_str')) {
    /**
     * 截取字符串
     * @param string $string
     * @param int $length
     * @param string $dot
     * @return string
     */
    function cut_str($string, $length, $dot = '...')
    {
        //记载原始内容
        $oldString = $string;
        $string = str_replace(array('&nbsp;', '&amp;', '&quot;', '&#039;', '&ldquo;', '&rdquo;', '&mdash;', '&lt;', '&gt;', '&middot;', '&hellip;'), array(' ', '&', '"', "'", '“', '”', '—', '<', '>', '·', '…'), $string);
        $iActLength = (strlen($string)+mb_strlen($string,"UTF-8"))/2;
        if($iActLength <= $length) {
            return $oldString;
        }

        $strcut = '';
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
}

/**
 * 截取中文
 * @param string $string
 * @param string $sublen
 * @param int $start
 * @param string $code
 * @return string
 */
function cut_str_zh($string, $sublen, $start = 0, $code = 'UTF-8')
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

if (!function_exists('str_random')) {
    /**
     * 随机固定长度字符串
     * @param int $length
     * @param int $type
     * @return string
     */
    function str_random($length = 30, $type = 1)
    {
        if ($type == 1) {
            $pool = '0123456789';
        } else if ($type == 2) {
            $pool = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        } else if ($type == 3) {
            $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        } else {
            return 1;
        }
        return substr(str_shuffle(str_repeat($pool, $length)), 0, $length);
    }
}

if (!function_exists('str_to_gbk')) {
    /**
     * utf8转gbk
     * @param string $str
     * @return string
     */
    function str_to_gbk($str)
    {
        return iconv("UTF-8", "GB2312//IGNORE", $str); // 这里将UTF-8转为GB2312编码
    }
}


if (!function_exists('json_encode_zh')) {
    /**
     * json_encode中文编码unicode处理
     * @param array $array
     * @return string
     */
    function json_encode_zh($array)
    {
        if(version_compare(PHP_VERSION,'5.4.0','<')){
            $str = json_encode($array);
            $str = preg_replace_callback("#\\\u([0-9a-f]{4})#i",function($matchs){
                return iconv('UCS-2BE', 'UTF-8', pack('H4', $matchs[1]));
            },$str);
            return $str;
        }else{
            return json_encode($array, JSON_UNESCAPED_UNICODE);
        }
    }
}

if (!function_exists('decode_unicode')) {
    /**
     * 创建匿名函数 和 json_encode()中文不转义处理
     * @param string $str
     * @return string
     */
    function decode_unicode($str)
    {
        return preg_replace_callback('/\\\u([0-9a-f]{4})/i',
            create_function(
                '$matches',
                'return mb_convert_encoding(pack("H*", $matches[1]), "UTF-8", "UCS-2BE");'
            ),
            $str);
    }
}




if (!function_exists('get_str_length')) {
    function get_str_length($str)
    {
        $str = str_replace(
            array('&nbsp;', '&amp;', '&quot;', '&#039;', '&ldquo;', '&rdquo;', '&mdash;', '&lt;', '&gt;', '&middot;', '&hellip;'),
            array(' ', '&', '"', "'", '“', '”', '—', '<', '>', '·', '…'),
            $str
        );
        $iActLength = (strlen($str)+mb_strlen($str,"UTF-8"))/2;
        return $iActLength;
    }
}

if (!function_exists('get_first_img')) {
    /**
     * 获取内容的第一个图片
     * @param string $sHtml
     * @return string
     */
    function get_first_img($sHtml)
    {
        preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $sHtml, $aMatches);
        if (!empty($aMatches[1][0])) {
            $aUrl = parse_url($aMatches[1][0]);
            // 如果是站内图片, 获取稍小的缩略图
            if (sg($aUrl['host']) == DOMAIN_WEBRES && (strpos($aUrl['path'], '/upload/thumb') === 0)) {
                $aPieces = preg_split('/[\/_]/', $aUrl['path']);
                return Upload::getThumb($aPieces[3].$aPieces[4].$aPieces[5], 'feed');
            } else {
                return $aMatches[1][0];
            }
        } else {
            return '';
        }
    }
}


if (!function_exists('sha256')) {
    /**
     * @param string $str
     * @param string $salt
     * @return string
     */
    function sha256($str,$salt='pwoerqwelkasdpfouaidsvqweprouqwe')
    {
        return hash('sha256',$str . $salt);
    }
}

if (!function_exists('has_keyword'))
{
    /**
     * 检查字符串是否包含某个词汇
     * @param string $str
     * @param array|string $words
     * @return string
     */
    function has_keyword($str, $words) {
        if (is_string($words)) {
            if (mb_stripos($str, $words) !== false ) {
                return $words;
            }
        } else {
            foreach ($words as $w) {
                if (mb_stripos($str, $w) !== false ) {
                    return $w;
                }
            }
        }
    }
}


if (!function_exists('user_agent_is_mobile')) {
    /**
     * 判断访问来源是否为移动设备
     * return true or false
     * iphone 返回： mozilla/5.0 (iphone; u; cpu iphone os 4_3_2 like mac os x; en-us) applewebkit/533.17.9 (khtml, like gecko) version/5.0.2 mobile/8h7 safari/6533.18.5
     * ipad 返回：mozilla/5.0 (ipad; u; cpu os 3_2 like mac os x; en-us) applewebkit/531.21.10 (khtml, like gecko) version/4.0.4 mobile/7b334b safari/531.21.10
     * android返回：mozilla/5.0 (linux; android 4.1.1; nexus 7 build/jro03d) applewebkit/535.19 (khtml, like gecko) chrome/18.0.1025.166 safari/535.19
     * WPhone 返回：mozilla/5.0 (compatible; msie 9.0; windows phone os 7.5; trident/5.0; iemobile/9.0; nokia; lumia 800)
     */
    function user_agent_is_mobile()
    {
        $agent = strtolower ($_SERVER['HTTP_USER_AGENT']);
        if (preg_match('/iphone|android|ipad|windows phone/', $agent)) {
            return true;
        }
        return false;
    }
}