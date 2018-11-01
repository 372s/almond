<?php

/**
 * 验证：必须包含字母、数字、下划线；
 * @param $str
 * @return bool
 */
function checkPsd($str) {
    $pattern = '/^[a-z_0-9]+$/i';
    if (preg_match($pattern, $str)) {
        return true;
    } else {
        return false;
    }
}

/**
 * 验证：email
 * \w == [A-Za-z0-9_]
 * @param $str
 * @return bool
 */
function checkEmail($str) {
    $pattern = '/^(\w)+([-.]\w+)*@(\w)+(\.\w{2,4}){1,3}$/';
    if (preg_match($pattern, $str)) {
        return true;
    } else {
        return false;
    }
}

/**
 * url匹配
 * @param $str
 * @return bool
 */
function checkURL($str) {
    $pattern = '/^http(s?):\/\/(?:[A-za-z0-9-]+\.)+[A-za-z]{2,4}(:\d+)?(?:[\/\?#][\/=\?%\-&~`@[\]\':+!\.#\w]*)?/';
    if (preg_match($pattern, $str)) {
        return true;
    } else {
        return false;
    }
}

/**
 * 检查是否有中文
 * @param string $str
 * @return bool
 */
function check_zh($str) {
    return preg_match('/[\x{4e00}-\x{9fa5}]+/u', $str);
}

/**
 * 验证：去除相邻重复；
 * 后向引用（逆向引用）：如果在模式中定义标准括号组，则之后可以在正则表达式中引用它。这称为“逆向引用”，并且此类型的组称为 “捕获组”。
 * 对一个正则表达式模式或部分模式两边添加圆括号将导致相关匹配存储到一个临时缓冲区中，所捕获的每个子匹配都按照在正则表达式模式中从左至右所遇到的内容存储。存储子匹配的缓冲区编号从 1 开始，连续编号直至最大99 个子表达式。每个缓冲区都可以使用 '\n' 访问，其中 n 为一个标识特定缓冲区的一位或两位十进制数。
 * 例如，在下面的正则表达式中，序列 \1 匹配在捕获括号组中匹配的任意子字符串： /(\d+)-by-\1/; // 匹配字符串：48-by-48
 * 可以通过键入 \1, \2,..., \99 在正则表达式中指定最多 99 个此类逆向引用。
 * @param $str
 * @return string
 */
function removeAdjacentRepetition($str) {
    $pattern = '/(.)\1/';
    return preg_replace($pattern,'$1',$str);
}

function replaceImageStyle($str) {
    $pattern = '/(<img\s*.*?\s*style=\").*?(\".*?\/?\s*>)/i';
    return preg_replace($pattern, '${1}width:100%;height:auto;${2}', $str);
}

/**
 * 非捕获元字符 '?:','?=','?!' 来忽略对相关匹配的保存
 * 其中?:是非捕获元之一，还有两个非捕获元是?=和?!，这两个还有更多的含义，前者为正向预查，在任何开始匹配圆括号内的正则表达式模式的位置来匹配搜索字符串，后者为负向预查，在任何开始不匹配该正则表达式模式的位置来匹配搜索字符串
 * @param string $str
 * @return array
 */
function noCaptureSymbol($str) {
    $str = "你好<我>(爱)[北京]{天安门}";
    preg_match("/(?:<)(.*)(?:>)/i", $str, $result1);
    return $result1;
    /* Array ( [0] => <我> [1] => 我 ) */

    // preg_match_all("/(?:<)(.*)(?:>)/i", $str, $result2);
    // print_r($result2);
    /* Array (
        [0] => Array
            (
                [0] => <我>
            )

        [1] => Array
            (
                [0] => 我
            )
    ) */
}