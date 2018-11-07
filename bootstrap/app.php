<?php

use Wpollen\Routing\Router;
use Wpollen\View\View;

// TODO 加载配置文件
require_once dirname(__DIR__) . '/routes/routes.php';

// TODO 中间件

register_shutdown_function(function() {
    $return = Router::dispatch();
    View::process($return);
});

// ==================================================== //
/**
 * 导入视图
 * @throws \InvalidArgumentException
 * @param mixed $name
 * @return object
 */
function view($name = null)
{
    return View::make($name);
}
// ==================================================== //
