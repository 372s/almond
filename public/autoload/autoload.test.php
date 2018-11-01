<?php

require_once dirname(__DIR__) . '/../vendor/autoload.php';



/**
 * Carbon\Carbon
 */
use Carbon\Carbon;
printf("Right now is %s", Carbon::now()->toDateTimeString() . "\n");
printf("Right now in Shanghai is %s", Carbon::now());  //implicit __toString()

/**
 * 验证码
 */
use Gregwar\Captcha\CaptchaBuilder;
header('Content-type: image/jpeg');
CaptchaBuilder::create()->build()->output();
print_r(glob(dirname(__FILE__).'/*.php'));die;

/**
 * 获取文件夹内文件
 */
use Symfony\Component\Finder\Finder;

$finder = Finder::create()->files()->ignoreDotFiles(true)->in(dirname(__FILE__))->depth(0);
print_r($finder);die;

$arr = [];
foreach ($finder as $key => $file) {
    $arr[$key]['getPathName'] = $file->getPathName();

    // dumps the absolute path
    $arr[$key]['getRealPath'] = $file->getRealPath();

    // dumps the relative path to the file, omitting the filename
    $arr[$key]['getRelativePath'] = $file->getRelativePath();

    // dumps the relative path to the file
    $arr[$key]['getRelativePathname'] = $file->getRelativePathname();
}
print_r($arr);die;

$arr = iterator_to_array(
    Finder::create()->files()->ignoreDotFiles(true)->in(dirname(__FILE__))->depth(0),
    false
);
$arr = array_map(function($file) {
    return $file->getPathName();
}, $arr);
print_r($arr);die;
