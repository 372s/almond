<?php

use Wpollen\Foundation\Application;
use Wpollen\Foundation\Bootstrap\RegisterProviders;

$app = new Application(dirname(__DIR__));
(new RegisterProviders())->bootstrap($app);

// TODO 加载配置文件
require_once dirname(__DIR__) . '/routes/routes.php';

// TODO 中间件
register_shutdown_function(function() {
    $return = Router::dispatch();
    View::process($return);
});

// 类自动加载
spl_autoload_register(function ($class) {
    require_once dirname(__DIR__) . '/lib/Support/' . $class . '.class.php';
});