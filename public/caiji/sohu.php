<?php
/**
 * Created by PhpStorm.
 * User: wq455
 * Date: 2018/10/29
 * Time: 00:25
 */

require_once dirname(__DIR__) . '/../lib/PHPQuery/phpQuery.php';
// 搜狐
//$souhu = file_get_contents('https://v2.sohu.com/integration-api/mix/region/98');
//$json = file_get_contents('https://v2.sohu.com/integration-api/mix/region/98');
//$data = json_decode($json, true);
//print_r($data);die;

header("Content-type: text/html; charset=utf-8");
set_time_limit(0);
$urls = array(
    'https://v2.sohu.com/integration-api/mix/region/90',
    'https://v2.sohu.com/integration-api/mix/region/92',
    'https://v2.sohu.com/integration-api/mix/region/94',
    'https://v2.sohu.com/integration-api/mix/region/98',
);

foreach ($urls as $url) {
    $json = file_get_contents($url);
    $data = json_decode($json, true);

    foreach ($data['data'] as $item) {

        if (empty($item['url'])) continue;
        if (strpos($item['url'], 'http') !== false) continue;

        $id = 'sohu_' . str_replace('/', '', $item['url']);
        $url = 'https://m.sohu.com'. $item['url'];
        $content = file_get_contents($url);


        $doc = phpQuery::newDocumentHTML($content);

        $title = pq('h2[class="title-info"]')->contents();

        $content1 = pq("div[class='display-content']")->html();
        if (!trim($content1)) {
            continue;
        }
        $content1 = preg_replace('/<strong>[\s\S]*?<\/strong>/', '', $content1);

        $content2 = pq("div[class='hidden-content hide']")->html();
        if (!trim($content2)) {
            continue;
        }
        $content2 = preg_replace('/<footer[\s\S]*?<\/footer>/', '', $content2);
        $content2 = preg_replace('/<section[\s\S]*?<\/section>/', '', $content2);

        $content = $content1 . $content2;
        $content = preg_replace('/<script[\s\S]*?>[\s\S]*?<\/script>/', '', $content);
        echo $id . "<br>";
        echo $title . "<br>";
//        echo $content . "<br>";
    }
}
