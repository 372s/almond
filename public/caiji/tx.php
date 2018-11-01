<?php
require_once dirname(__DIR__) . '/../lib/PHPQuery/phpQuery.php';
require_once dirname(__FILE__) . '/helpers.php';

header("Content-type: text/html; charset=utf-8");
set_time_limit(0);

/* 重定向天天快报 */
// // $html = file_get_contents('http://kuaibao.qq.com/s/20181029A18LRT00'); // 柑橘黄龙病
// $html = file_get_contents('http://kuaibao.qq.com/s/20181030A1CIOT00'); // 王熙凤
// // echo $html;die;
// preg_match('/<div class=\"content-box\">([\s\S]*?)<div id=\"showMore\"/', $html, $ma);
// $content = $ma[1];
// $content = '<div>' . rtrim(trim($content), '</div>');
// $content = rtrim(trim($content), '<br>');
// echo $content;die;

/* 腾讯本站 */
// $doc = file_get_contents('https://xw.qq.com/cmsid/20181030A1CIOT00');
// // echo $doc;die;
// preg_match("/contents:\s*(\[[\s\S]*?\]),\s*?ext_data/", $doc, $ma);
// // print_r($ma[1]);die;
// print_r(json_decode($ma[1], true));
// preg_match('/\"cnt_attr\":([\s\S]*?),\"cnt_html\"/', $doc, $ext);
// print_r(json_decode($ext[1], true));die;

/* 腾讯本站 */
$arrjson = array(
    'https://pacaio.match.qq.com/xw/topNews?num=20&expIds=20181030011842%7C20181030A1JRFI%7C20181030013477%7C20181030013641%7C20181030A1KF2X%7C20181029009942%7C20181030A1A5OQ%7C20181030A1WE3L%7C20181030A1WJCB%7C20181026A01AWP%7C20181030A0AEXV%7C20181030A1VQN3&refresh=0', // 要闻
    'https://pacaio.match.qq.com/irs/rcd?cid=56&ext=house&token=c786875b8e04da17b24ea5e332745e0f&num=20&expIds=20181030A0C4P3%7C20181030A1P775&page=0', // 房产
    'https://pacaio.match.qq.com/xw/site?uid=0_135d373857b4a&ext=edu&num=20&expIds=&page=0', //教育
    'https://pacaio.match.qq.com/irs/rcd?cid=56&ext=cul&token=c786875b8e04da17b24ea5e332745e0f&num=20&expIds=20181030013486%7C20181030A1U7M0&page=0', // 文化
    'https://pacaio.match.qq.com/irs/rcd?cid=56&ext=health&token=c786875b8e04da17b24ea5e332745e0f&num=20&expIds=20181030A14GU1%7C20181024A0UB44&page=0', // 健康
    'https://pacaio.match.qq.com/xw/site?uid=0_6d3466ab3f225&ext=tech&num=20&expIds=&page=0', // 科技
);


foreach ($arrjson as $url) {
    $file = file_get_contents($url);

    $arr = json_decode($file, true);

    foreach ($arr['data'] as $row) {
        $url = $row['url'];
        $title = $row['title'];
        if (!empty($row['app_id'])) {
            $id = $row['app_id'];
        } else {
            // print_r($row);
            // echo "<br>";
            continue;
        }
        $doc = file_get_contents($url);
        // echo $doc;die;
        if(! preg_match("/contents:\s*(\[[\s\S]*?\]),\s*?ext_data/", $doc, $ma)) {
            continue;
        }
        $res = json_decode($ma[1], true);

        if (preg_match('/\"cnt_attr\":([\s\S]*?),\"cnt_html\"/', $doc, $ext)) {
            $arr_img = json_decode($ext[1], true);
        } else {
            $arr_img = array();
        }
        $content = '';
        $i = 0;
        foreach ($res as $r) {
            // 图片
            if ($r['type'] == 2 && !empty($arr_img['IMG_'.$i]['all']['img']['imgurl641']['imgurl'])) {
                $imgsrc = $arr_img['IMG_'.$i]['all']['img']['imgurl641']['imgurl'];

                $lj = dirname(__DIR__) . '/uploads/'  . date('ymd') . '/';
                $xinarc = create_img($imgsrc, $lj);
                $xinarc = str_replace(dirname(__DIR__), "http://php-study.test", $xinarc);
                $content .= '<img src="' . $xinarc . '">';
                $i++;
            }
            if ($r['type'] == 1) {
                $content .= '<p>'.$r['value'].'</p>';
            }
        }
        echo $id . "<br>" ;
        echo $title . "<br>" ;
        echo $content . "<br>" ;
        // die;
    }
    // break;
}