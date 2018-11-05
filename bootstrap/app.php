<?php

// TODO 加载配置文件
require_once dirname(__DIR__) . '/routes/routes.php';

// TODO 中间件

register_shutdown_function(function() {
    \Bootstrap\Router::dispatch();
});