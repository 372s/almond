<?php

/**
 * forward_static_call_array() 调用静态方法，并传入参数
 */
class A
{
    const NAME = 'A';
    public static function test() {
        $args = func_get_args();
        echo static::NAME, " ".join(',', $args)." \n";
    }
}

class B extends A
{
    const NAME = 'B';

    public static function test() {
        echo self::NAME, "\n";
        forward_static_call_array(array('A', 'test'), array('more', 'args'));
        forward_static_call_array( 'test', array('other', 'args'));
    }
}

B::test('foo');

function test() {
    $args = func_get_args();
    echo "C ".join(',', $args)." \n";
}


/**
 * func_get_args() 获取方法传入的参数
 */
function get_func_args()
{
    $arr = func_get_args();
    extract($arr, EXTR_PREFIX_ALL, 'var'); // 索引函数会以var_0实现参数
    print_r(get_defined_vars());
}
get_func_args(1, 2);die;



/**
 * get_defined_vars() 获取定义的参数
 */
$b = array(1, 1, 2, 3, 5, 8);
$arr = get_defined_vars();
// 打印 $b
print_r($arr["b"]);

// 打印 PHP 解释程序的路径（如果 PHP 作为 CGI 使用的话）
// 例如：/usr/local/bin/php
echo $arr["_"];

// 打印命令行参数（如果有的话）
print_r($arr["argv"]);

// 打印所有服务器变量
print_r($arr["_SERVER"]);

// print_r($arr['php_errormsg']);

// 打印变量数组的所有可用键值
print_r(array_keys(get_defined_vars()));



/**
 * 创建匿名函数 和 json_encode()中文不转义处理
 */
function decodeUnicode($str)
{
    return preg_replace_callback('/\\\u([0-9a-f]{4})/i',
        create_function(
            '$matches',
            'return mb_convert_encoding(pack("H*", $matches[1]), "UTF-8", "UCS-2BE");'
        ),
        $str);
}
$arr = array('姓名' => '张三', '李四');
echo serialize($arr);
echo json_encode($arr);
echo json_encode($arr, JSON_UNESCAPED_UNICODE);
$res = decodeUnicode(json_encode($arr));
print_r(json_decode($res, true));


/**
 * array_splice() 截取数组
 */
$input = array("red", "green", "blue", "yellow");
$arr = array_splice($input, 0, 2);
print_r($arr); // array("red", "green")
print_r($input); // array("blue", "yellow")

/**
 * array_diff() 数组的差集
 */
$array1 = array("a" => "green", "red", "blue");
$array2 = array("b" => "green", "red", "yellow");
$result = array_diff($array2, $array1);
print_r($result); // Array ( [1] => yellow ) 


/**
 * 生成器 Generators 
 * php5.5新特性
 */
function gen_one_to_three()
{
    for ($i = 1; $i <= 3; $i++) {
        //注意变量$i的值在不同的yield之间是保持传递的。
        yield $i;
    }
}
$generator = gen_one_to_three();
print_r(iterator_to_array($generator));




/**
 * mb_strpos | strpos
 * 注意这里使用的是 ===。简单的 == 不能像我们期待的那样工作，
 * 因为 'a' 是第 0 位置上的（第一个）字符。
 */
$mystring = 12345678;
$findme   = 8;
$pos = mb_strpos($mystring, $findme);
if ($pos === false) {
    echo "The string '$findme' was not found in the string '$mystring'";
} else {
    echo "The string '$findme' was found in the string '$mystring'";
    echo " and exists at position $pos";
}