<?php
$url = '/helpcenter/reply.php?id=8';


$paserUrl = function($url) {
    $arr = parse_url($url);
    return $arr['query'];
};

print_r($paserUrl($url));

parse_str($paserUrl($url), $output);

print_r($output);