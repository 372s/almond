<?php

define('APP_START', microtime(true));

define('ROOT_PATH', dirname(__DIR__) . '/');

define('PUBLIC_PATH', ROOT_PATH. 'public/');

define('LIB_PATH', ROOT_PATH . 'lib/');

define('CLASS_EXT', '.class.php');

define('FUNC_EXT', '.func.php');

if (file_exists(dirname(__DIR__) . '/vendor/autoload.php')) {
    require_once dirname(__DIR__) . '/vendor/autoload.php';
}