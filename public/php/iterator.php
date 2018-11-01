<?php

##########################################################
# 递归函数
##########################################################
$arr = array(
    array('id' => 1, 'name' => '河南省', 'pid' => 0),
    array('id' => 2, 'name' => '信阳市', 'pid' => 1),
    array('id' => 3, 'name' => '开封市', 'pid' => 1),
    array('id' => 6, 'name' => '广州市', 'pid' => 4),
    array('id' => 4, 'name' => '广东省', 'pid' => 0),
    array('id' => 5, 'name' => '深圳市', 'pid' => 4),
);

function recursive($data, $pid = 0)
{
    $arr = array();
    $i = 0;
    foreach ($data as $k => $v) {
        if ($v['pid'] == $pid) {
            $arr[$i] = $v;
            // $arr[$i]=array_merge($arr,recursive($data, $v['id']));
            $arr[$i]['city'] = recursive($data, $v['id']);
        }
        $i++;
    }
    return $arr;
}
// print_r(recursive($arr, 0));

##########################################################
# 读取目录下所有文件和子目录
# 队列方式：read_dir_queue
# 递归方式：read_dir
##########################################################
function read_dir_queue($dir)
{
    $files = array();
    $queue = array($dir);
    while ($data = each($queue)) {
        // print_r($data);die;
        $path = $data['value'];
        if (is_dir($path) && $handle = opendir($path)) {
            while ($file = readdir($handle)) {
                if ($file == '.' || $file == '..') {
                    continue;
                }

                $files[] = $real_path = $path . '/' . $file;
                if (is_dir($real_path)) {
                    $queue[] = $real_path;
                }

            }
        }
        closedir($handle);
    }
    return $files;
}
// print_r(read_dir_queue('E:/laragon/www/study/php-study'));

function read_dir($dir)
{
    $files = array();
    $dir_list = scandir($dir);
    foreach ($dir_list as $file) {
        if ($file != '..' && $file != '.') {
            if (is_dir($dir . '/' . $file)) {
                $files[] = read_dir($dir . '/' . $file);
            } else {
                $files[] = $file;
            }
        }
    }
    return $files;
}


##########################################################
# RecursiveTreeIterator 以可视在方式显示一个树形结构。
##########################################################
$hey = array("a" => "lemon", "b" => "orange", array("a" => "apple", "p" => "pear"));
$awesome = new RecursiveTreeIterator(
    new RecursiveArrayIterator($hey),
    null,
    null,
    RecursiveIteratorIterator::LEAVES_ONLY
);
foreach ($awesome as $line) {
    // echo $line . PHP_EOL;
}

##########################################################
# 迭代器 CachingIterator
##########################################################
//
$cache = new CachingIterator(new ArrayIterator(range(1, 100)), CachingIterator::FULL_CACHE);
foreach ($cache as $c) {

}
// print_r($cache->getCache());

##########################################################
# 迭代器 目录文件遍历器
##########################################################
$it = new DirectoryIterator("./");
foreach ($it as $file) {
    //用isDot()方法分别过滤掉“.”和“..”目录
    if (!$it->isDot() && $file->isFile()) {
        // echo $file->getFilename() . "\n" . $file->getExtension() . "<br />";
    }
}

$it = new FilesystemIterator(dirname(__FILE__));
foreach ($it as $fileinfo) {
    if ($fileinfo->isFile()) {
        // echo $fileinfo->getFilename() . "\n";
    }
}

##########################################################
# php数组函数 each()和reset()连用
##########################################################
$a = array(1, 2, 3);
foreach ($a as $k => $v) {
    $a[$k] = 2 * $v;
}

// If you forget to reset the array before each(), the same code may give different results with different php versions.
reset($a);
while (list($k2, $v2) = each($a)) {
    // echo($v2."\n");
}

##########################################################
# 迭代器 ArrayIterator() | ArrayObject()
##########################################################
$b = array(
    'name' => 'mengzhi',
    'age' => '12',
    'city' => 'shanghai',
);
$a = new ArrayIterator($b);
// $a->append(array(
//                 'home' => 'china',
//                 'work' => 'developer'
//            ));
$c = $a->getArrayCopy();

$obj = new ArrayObject($b); //创建数组对象
$d = $obj->getIterator();
$e = $obj->getArrayCopy();
// print_r($a);
// print_r($c);
// print_r($obj);
// print_r($d);
// print_r($e);

foreach ($a as $key => $value) {
    // echo $key ." : ".$value."<br/>";
}

foreach ($d as $key => $value) {
    // echo $key ." : ".$value."<br/>";
}

$d->rewind(); //如果要使用current必须使用rewind
while ($d->valid()) {
    // echo $d->key()." : ".$d->current()."<br/>";
    $d->next();
}