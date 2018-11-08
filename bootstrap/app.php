<?php

// use Wpollen\Routing\Router;
// use Wpollen\View\View;
class_alias('Wpollen\Routing\Router', 'Router');
class_alias('Wpollen\View\View', 'View');

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