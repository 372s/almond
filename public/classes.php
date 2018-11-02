<?php

// 类自动加载
spl_autoload_register(function ($class) {
    include dirname(__DIR__) . '/lib/classes/' . $class . '.class.php';
});