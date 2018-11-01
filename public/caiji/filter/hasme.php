<?php

$html = '
<article class="blue" style="width: 10px;">
<img src="http://41234128430908123.jpg" style="width: 200px;">
<p style="width: 10px;">我是公司的分公司的风格我</p>
</article>';

var_dump(filter_me($html));die;

function filter_me($html) {
    $str = trim(strip_tags($html));
    return (strpos($str, '我') === 0);
}

