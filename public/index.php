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


// load('PHPPager.Pager');
// $page = new \PHPPager\Pager();
// print_r($page);

// use App\Filesystem\Filesystem;
//
// $res = Filesystem::create()->in((BASE_PATH . '/config'));
//
// foreach ($res as $file) {
//     print_r($file);
// }
// die;

$path = dirname(__DIR__) . '/config';
$directory = new \RecursiveDirectoryIterator($path, \RecursiveIteratorIterator::LEAVES_ONLY);
$iterator = new \RecursiveIteratorIterator($directory);
$dirs = array();
foreach ($iterator as $dir) {
    // $dirs[] = $dir->getPathname();
    if ($dir->isDir()) {
        $dirs[] = rtrim($dir->getPathname(), '.');
    }
}
print_r($dirs);die;


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
