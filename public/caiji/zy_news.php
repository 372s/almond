<?php
/**
 * Created by PhpStorm.
 * User: wangqiang
 * Date: 2018/10/29
 * Time: 15:53
 */

require_once dirname(__DIR__) . '/../lib/PHPQuery/phpQuery.php';
require_once dirname(__FILE__) . '/helpers.php';

set_time_limit(0);
header("Content-type: text/html; charset=GBK2312");

// 教育频道 乱码问题
$doc = phpQuery::newDocumentFile('http://edu.zynews.cn/e/wap/');
$t = $doc->html();
$t = mb_convert_encoding($t,'ISO-8859-1','utf-8');
$t = mb_convert_encoding($t,'utf-8','GBK');
echo $t;die;

$urls = array(
    // 'http://jk.zynews.cn/e/wap/',// 健康
    // 'http://lvyou.zynews.cn/e/wap/',// 旅游
    'http://edu.zynews.cn/e/wap/',// 教育
    // 'http://house.zynews.cn/e/wap/',// 房产
);

foreach ($urls as $url) {
    $html = file_get_contents($url);
    $dom = phpQuery::newDocumentHTML($html);
    $href = $dom->find('h3[class="image-margin-right"] > a');
    // print_r($href);die;

    foreach ($href as $h) {
        $h = pq($h)->attr('href');


        $arr = parse_url($h,PHP_URL_QUERY);
        parse_str($arr, $output);

        $id = 'zy_' . $output['classid'] . '_' . $output['id'];
        echo $id . "<br>";

        $content = file_get_contents($url . $h);

        // if (preg_match('/<article class=\"article\">([\s\S]*?)<\/article>/', $content, $matches)) {
        //     $content = $matches[1];
        // } else {
        //     continue;
        // }
        //
        // if (preg_match('/<header class=\"articleHeader\">([\s\S]*?)<\/header>/', $content, $title)) {
        //     $title = $title[1];
        // } else {
        //     continue;
        // }
        $doc = phpQuery::newDocumentHTML($content);
        $title = $doc->find('header[class="articleHeader"]')->children('h1')->contents();

        echo $title . "<br>";
        // $title = mb_convert_encoding($title, "GB2312", 'UTF-8');

        // echo mb_detect_encoding($title). "<br>";

        // $content = $doc->find('div[id="text"]')->contents();
        // $img_src = $doc->find('img');
        //
        // $host = 'http://' . parse_url($url, PHP_URL_HOST);
        // foreach ($img_src as $img) {
        //     $img = pq($img)->attr('src');
        //     if (strpos($img, 'http') === false) {
        //         $content = str_replace($img, $host . $img, $content);
        //     }
        // }
        // $content = img_url_local($content);
        // echo $content . "<br>";
    }
}