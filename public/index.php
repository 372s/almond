<?php

define('APP_START', microtime(true));
define('PUBLIC_PATH', __DIR__);
define('BASE_PATH', dirname(__DIR__));
define('ROOT_PATH', BASE_PATH);
define('LIB_PATH', ROOT_PATH . '/lib');

require_once dirname(__DIR__) . '/bootstrap/autoload.php';
require_once dirname(__DIR__) . '/bootstrap/app.php';
require_once dirname(__DIR__) . '/lib/Common/functions.php';

