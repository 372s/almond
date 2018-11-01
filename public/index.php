<?php

define('APP_START', microtime(true));

define('ROOT_PATH', dirname(__DIR__) . '/');

define('PUBLIC_PATH', ROOT_PATH. '/public/');

define('APP_HOST', 'http://php-study.test');

require_once PUBLIC_PATH . 'helpers.php';
require_once PUBLIC_PATH . 'classes.php';

// var_dump(spl_autoload_functions());

// print_r(spl_classes());
$a = '公司股份的';
echo mb_strlen ($a);die;
$str1 = 'hello1';
$str2 = 'hello1';
echo strcasecmp ($str1, $str2);