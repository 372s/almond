<?php

$app = new Bootstrap\Application(
    realpath(__DIR__.'/../')
);

// TODO 加载配置文件
require_once dirname(__DIR__) . '/routes/routes.php';

// TODO 中间件

register_shutdown_function(function() {
    $return = \Bootstrap\Routing\Router::dispatch();
    \Bootstrap\View\View::process($return);
});

echo '@app.php' . "<br>";