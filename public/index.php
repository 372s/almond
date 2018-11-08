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



use App\Filesystem\Filesystem;
// use App\Finder\Finder;
use Nette\Utils\Finder;

$path = BASE_PATH . '/config';
$iterator = Finder::findDirectories()->in($path);


// $res = Finder::create()->files()->in($path);
foreach ($iterator as $key => $file) {
    print_r($file);
    print_r($key);
}
die;

