<?php
require_once 'ydzx_curl.php';

set_time_limit(0);
header("Content-type: text/html; charset=utf-8");

$channels = array(
    'http://www.yidianzixun.com/home/q/news_list_for_channel?channel_id=best&cstart=0&cend=10&infinite=true&refresh=1&__from__=wap&docids=0KJCWV23%2C0KIh4jyU%2C0KIXYQGS%2CV_01wylP3P%2C0KJGp5WD&_spt=yz~eaodhoy~%3A%3B%3A&appid=web_yidian&_=1540052655146', //推荐
    'http://www.yidianzixun.com/home/q/news_list_for_channel?channel_id=22658408712&cstart=0&cend=10&infinite=true&refresh=1&__from__=wap&_spt=yz~eaod88%3C%3F2%3E%3A2%3D%3B8%3A%3B%3A&appid=web_yidian&_=1540052655146', // 新时代
    'http://www.yidianzixun.com/home/q/news_list_for_channel?channel_id=12668662376&cstart=0&cend=10&infinite=true&refresh=1&__from__=wap&_spt=yz~eaod%3B8%3C%3C2%3C%3C89%3D%3C%3A%3B%3A&appid=web_yidian&_=1540052872488', // 汽车
    'http://www.yidianzixun.com/home/q/news_list_for_channel?channel_id=12668662216&cstart=0&cend=10&infinite=true&refresh=1&__from__=wap&_spt=yz~eaod%3B8%3C%3C2%3C%3C88%3B%3C%3A%3B%3A&appid=web_yidian&_=1540052680776', // 娱乐
    'http://www.yidianzixun.com/home/q/news_list_for_channel?channel_id=12668662232&cstart=0&cend=10&infinite=true&refresh=1&__from__=wap&_spt=yz~eaod%3B8%3C%3C2%3C%3C8898%3A%3B%3A&appid=web_yidian&_=1540052896189', // 军事
    'http://www.yidianzixun.com/home/q/news_list_for_channel?channel_id=12668662248&cstart=0&cend=10&infinite=true&refresh=1&__from__=wap&_spt=yz~eaod%3B8%3C%3C2%3C%3C88%3E2%3A%3B%3A&appid=web_yidian&_=1540052708548', // 体育
    'http://www.yidianzixun.com/home/q/news_list_for_channel?channel_id=12668662264&cstart=0&cend=10&infinite=true&refresh=1&__from__=wap&_spt=yz~eaod%3B8%3C%3C2%3C%3C88%3C%3E%3A%3B%3A&appid=web_yidian&_=1540052759873', // nba
    'http://www.yidianzixun.com/home/q/news_list_for_channel?channel_id=12668662280&cstart=0&cend=10&infinite=true&refresh=1&__from__=wap&_spt=yz~eaod%3B8%3C%3C2%3C%3C882%3A%3A%3B%3A&appid=web_yidian&_=1540052782375', // 财经
    'http://www.yidianzixun.com/home/q/news_list_for_channel?channel_id=22658408728&cstart=0&cend=10&infinite=true&refresh=1&__from__=wap&_spt=yz~eaod88%3C%3F2%3E%3A2%3D82%3A%3B%3A&appid=web_yidian&_=1540052807281', // 文化
    'http://www.yidianzixun.com/home/q/news_list_for_channel?channel_id=12668662296&cstart=0&cend=10&infinite=true&refresh=1&__from__=wap&_spt=yz~eaod%3B8%3C%3C2%3C%3C883%3C%3A%3B%3A&appid=web_yidian&_=1540052128825', // 科技
    'http://www.yidianzixun.com/home/q/news_list_for_channel?channel_id=12668662360&cstart=0&cend=10&infinite=true&refresh=1&__from__=wap&_spt=yz~eaod%3B8%3C%3C2%3C%3C89%3C%3A%3A%3B%3A&appid=web_yidian&_=1540052847247', // 时尚
);
foreach ($channels as $channel) {
    ydpindao($channel);
}

function ydpindao($url) {
    $json = curl_get_content($url);
//    print_r($json);
    $res = json_decode($json, true);
//    print_r($res);die;

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
        // 处理图片
        if (!empty($value['image_urls'])) {
            foreach ($value['image_urls'] as $k => $img) {
                $content = preg_replace("/<div id=\"article-img-$k\"[\s\S]*?>[\s\S]*?<\/div>/", '<img src="http://i1.go2yd.com/image.php?url='.$img.'">', $content);
            }
        }

        if (preg_match('/<article id=\"js-article\"[\s\S]*?>(.*?)<\/article>/', $content, $matches)) {
            $content = $matches[1];
        } else {
            continue;
        }
        $content = preg_replace("/<div id=\"article-img-[\s\S]*?>[\s\S]*?<\/div>/", '', $content);
        $content = preg_replace('/<script[\s\S]*?<\/script>/i', '', $content);
        $content = preg_replace('/<video[\s\S]*?<\/video>/i', '', $content);
        $word = array("价格", "购买", "￥", "QQ群", "股票", "彩票", "王者荣耀", "传真", "互粉", "电话", "足彩", "大乐透", "双色球", "套花呗", "信用卡套现". "未经授权不得转载");

        if (filter($content, $word)) continue;
        $content = preg_replace('/(<a href=\")([\s\S]*?)(\"[\s\S]*?>)/i', "$1javascript:;$3", $content);

        if (strlen($content) < 100) continue; //如果内容少于33字就跳过

        echo '[id] ' . $id . "<br>";
//        echo '[title] ' . $title . "<br>";
//        echo $content . "<br>";
    }
}



