<?php

$arr = array(
    'aaaa' => array('id' => 1, 'name' => '河南省', 'pid' => 0),
    array('id' => 2, 'name' => '信阳市', 'pid' => 1),
    array('id' => 3, 'name' => '开封市', 'pid' => 1),
    array('id' => 6, 'name' => '广州市', 'pid' => 4),
    array('id' => 4, 'name' => '广东省', 'pid' => 0),
    array('id' => 5, 'name' => '深圳市', 'pid' => 4),
);

print_r(array_map('key', $arr));die;