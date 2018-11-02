<?php

if (!function_exists('str_microtime')) {
    /**
     * 获取当前毫秒的时间
     */
    function get_microtime()
    {
        list($t1, $t2) = explode(' ', microtime());
        return (float) sprintf('%.0f', (floatval($t1) + floatval($t2)) * 1000);
    }
}