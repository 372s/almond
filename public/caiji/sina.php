<?php
/**
 * Created by PhpStorm.
 * User: wq455
 * Date: 2018/10/28
 * Time: 23:48
 */

require_once dirname(__DIR__) . '/../lib/PHPQuery/phpQuery.php';

header("Content-type: text/html; charset=utf-8");
set_time_limit(0);
$url = "https://interface.sina.cn/wap_api/layout_col.d.json?showcid=12635&col=12658&level=1%2C2%2C3";
$data = file_get_contents($url);
$arr = json_decode($data, true);

foreach ($arr['result']['data']['list'] as $art) {
    $url = $art['pc_url'];
    $content = file_get_contents($url);
    $doc = phpQuery::newDocumentHTML($content);
    $content = pq("div[id='artibody']")->html();
    $content = preg_replace('/<script[\s\S]*?>[\s\S]*?<\/script>/', '', $content);

    $content = preg_replace('/<a onmouseover[\s\S]*?<\/a>/', '', $content);
}


// 备份
// function sina($res) {
/*    $pertten = "/(<img class=\"sharePic hide\"[\s\S]*?>)([\s\S]*?)(<figure class=\"art_img_mini j_p_gallery\"[\s\S]*?>[\s\S]*?<\/figure>)([\s\S]*?)<p class=\"art_p\">.*?<a onmouseover[\s\S]*?>/";*/
//     if (preg_match_all($pertten, $res, $c)) {
//
/*        /*$img = preg_replace("/(<img[\s\S]*?src=\")([\s\S]*?)(\"[\s\S]*?>)/", '${1}http:${2}${3}', $c[1][0]);*/
//         // $content = "<div>".$c[2][0].$img.$c[4][0]."</div>";
//         $content = "<div>" . $c[2][0] . $c[1][0] . $c[4][0] . "</div>";
/*        $content = preg_replace("/<figure class=\"art_img_mini j_p_gallery\"[\s\S]*?>[\s\S]*?<\/figure>/", '', $content);*/
//         $content = str_replace("src=\"//", "src=\"http://", $content);
//         // $content = $this->img_location($content);
//         $content = $this->img_replace($content);
//
//         // echo $title . "<br>";
//         // echo $content . "<br>";
//         // die;
//         //插入数据库
//         // $this->addNews("手机新浪", $url, "情感", $title, $content, 1, $id);
//
//     }
// }