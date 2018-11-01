<?php
require_once 'ydzx_curl.php';

/* 详情 */
$url = 'http://www.yidianzixun.com/article/0KIXYQGS?s=';
$content = curl_get_content($url);
//echo get_query_fuc($content);
echo get_dom_fuc($content);

function get_dom_fuc($content) {
    $dom = new DOMDocument();
    @$dom->loadHTML($content);
    $xpath = new DomXPath($dom);
    $article = $xpath->query('//article[@id="js-article"]'); //output 2 -> correct
    return $dom->saveHTML($article->item(0));
}