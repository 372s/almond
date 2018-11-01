<?php

// 字符串处理

echo sprintf('%09d', 3322) . "<br>"; // 十位数
echo sprintf('$req: %d; $opt: %d; number of params: %d.', 1, 2, 1) . "<br>";

$format = 'The %2$s contains %1$d monkeys';
echo sprintf($format, 1, 'd');