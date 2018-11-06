<?php

/**
 * 获取当前毫秒的时间
 */
function micro_time()
{
    list($t1, $t2) = explode(' ', microtime());
    return (float) sprintf('%.0f', (floatval($t1) + floatval($t2)) * 1000);
}