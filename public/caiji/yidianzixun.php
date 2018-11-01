<?php
/**
 * Created by PhpStorm.
 * User: wangqiang
 * Date: 2018/10/16
 * Time: 16:48
 */

require_once 'ydzx_curl.php';

set_time_limit(0);
$content = curl_get_content('http://www.yidianzixun.com/home/q/news_list_for_channel?channel_id=best&cstart=0&cend=10&infinite=true&refresh=1&__from__=wap&docids=0KII0UX6%2C0KGdSHmh%2C0KI5XUrI%2C0KI9laum%2C0KGM4vJb&_spt=yz~eaodhoy~%3A%3B%3A&appid=web_yidian&_=1539879112123');
$res = json_decode($content, true);
 print_r($res);die;
$res = $res['result'];

foreach ($res as $value) {
    if (empty($value['docid'])) {
        continue;
    }

    $id = 'ydzx_'. $value['docid'];
    $title = $value['title'];
    $word_titles = array('佛教', '聚餐', '钥匙');
    if (filter($title, $word_titles)) continue;

    $url = 'http://www.yidianzixun.com/article/' . $value['docid'];
    $content = curl_get_content($url);
}
