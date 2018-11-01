<?php

set_time_limit(0);
function curl_get($url) {
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($curl);
    $error = curl_error($curl);
    curl_close($curl);
    $output = trim($output, "\xEF\xBB\xBF");
    return $output;
}

$html = file_get_contents('http://m.zynews.cn/');
//建立Dom对象，分析HTML文件；
$doc = new DOMDocument;
@$doc->loadHTML($html);
$doc->validateOnParse = true;
$doc->preserveWhiteSpace = false;

$xpath = new DOMXpath($doc);
$res = $xpath->query('//h3/a/@href');
foreach ($res as $re) {
    $url = ($re->value);

    preg_match("/\/([\w]+?)\.htm/", $url, $ids);
    $id = $ids[1];

    $cHtml = curl_get('http://m.zynews.cn/'.$url);

    if (preg_match("/<h1>([\s\S]*?)<\/h1>/i", $cHtml, $t)) {
        // print_r($t);
        $title = trim($t[1]); //获取标题
        if ($title == "404 Not Found") continue;
        echo $title;
    } else {
        continue;
    }

    if(preg_match('/<div class=\"text\"[\s\S]*?>(.*)<\/div>/', $cHtml, $matches)) {
        print_r($matches[0]);
    } else {
        continue;
    }
}

die;


$urls = array();
$titles = array();
$res = $xpath->query('//h3/a');
foreach ($res as $k => $c) {
    $a = $res->item($k);
    array_push($urls,$a->getAttribute("href"));
    array_push($titles,$a->nodeValue);
}
// print_r($urls);die;

$contents = array();
$i = 0;
foreach ($urls as $k => $url) {
    echo $titles[$k] . "<br>";
    preg_match("/\/([\w]+?)\.htm/", $url, $ids);
    $id = $ids[1];
    // echo 'http://m.zynews.cn/'.$url . "<br>";
    // $cHtml = file_get_contents('http://m.zynews.cn/'.$url);
    $cHtml = curl_get('http://m.zynews.cn/'.$url);
    // print_r($cHtml);
    // echo "<br>";
    // $cHtml = curl_get('http://m.zynews.cn/zz/2018-10/16/content_11549303.htm');
    // print_r($cHtml);die;
    // echo $cHtml;
    preg_match_all('/<div class=\"text\"[\s\S]*?>(.*)<\/div>/', $cHtml, $matches);
    if (empty($matches[0])) continue;
    $content = $matches[0][0];
    // print_r($content);
    // if (empty($matches) || empty($matches[0][0])) continue;
    // $content = $matches[0][0];
    // if (strlen($content) < 100) continue;
    //
    //
    // $content = preg_replace('/<script[\s\S]*?<\/script>/i', '', $content);
    // // echo $content;
    // array_push($contents, $content);


    // echo $content;
    /* $cHtml = Requests::get('http://m.zynews.cn/'.$url);
    $doc = new DOMDocument;
    @$doc->loadHTML($cHtml->body);
    $doc->validateOnParse = true;
    $doc->preserveWhiteSpace = false;
    $text = $doc->getElementById('text');
    array_push($contents, $doc->saveHTML($text));*/
    // echo $titles[$k];
    /*preg_match_all('/<div class=\"text\"[\s\S]*?>(.*)<\/div>/', $cHtml->body, $matches);*/
    // print_r($matches);die;
    $i++;
}
// print_r($contents);
// echo count($contents);die;
// echo $i;