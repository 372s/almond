<?php

define('APP_START', microtime(true));
define('PUBLIC_PATH', __DIR__);
define('BASE_PATH', dirname(__DIR__));
define('ROOT_PATH', BASE_PATH);
define('LIB_PATH', ROOT_PATH . '/lib');
define('VIEW_BASE_PATH', ROOT_PATH . '/app/views/');

require_once dirname(__DIR__) . '/bootstrap/autoload.php';
require_once dirname(__DIR__) . '/lib/Common/functions.php';
require_once dirname(__DIR__) . '/bootstrap/app.php';

echo '@index.php' . "<br>";

// print_r(glob(BASE_PATH . '/config/*.php', GLOB_BRACE));
// $dir = new DirectoryIterator((BASE_PATH . '/config'));
// foreach ($dir as $file) {
//     //用isDot()方法分别过滤掉“.”和“..”目录
//     if (! $dir->isDot() && $file->isFile()) {
//         // echo $file->getFilename() . "\n" . $file->getExtension() . "<br />";
//     } else if ($file->isDir()) {
//         // print_r(glob($file));
//     }
// }

// load('PHPPager.Pager');
// $page = new \PHPPager\Pager();
// print_r($page);

$path = dirname(__DIR__) . '/config';
$directory = new \RecursiveDirectoryIterator($path, FilesystemIterator::SKIP_DOTS);
$iterator = new \RecursiveIteratorIterator($directory);
$files = array();
foreach ($iterator as $info) {
    // if ($info->isFile()) {
        $files[] = $info->getPathname();
    // }
}
print_r($files);die;
// use RecursiveIteratorIterator;
use Bootstrap\SystemFileIterator;

$res = SystemFileIterator::create()->in((BASE_PATH . '/config'));

foreach ($res as $file) {
    print_r($file);
}