<?php

set_time_limit(0);
header("Content-type: text/html; charset=utf-8");

$urls = array(
    'https://4g.dahe.cn/list/0/0/10',
    'https://4g.dahe.cn/list/2/0/10',
    'https://4g.dahe.cn/list/3/0/10',
    'https://4g.dahe.cn/list/5/0/10',
    'https://4g.dahe.cn/list/7/0/10',
);

foreach ($urls as $url) {
    preg_match('/list\/(\d*?)\//', $url, $num);
    $json = get_dahe_content($url, $num[1]);
    $items = json_decode($json, true);
    $arr = $items['data'];
    get_content($arr, $num[1]);
}


function get_content ($arr, $num) {
    foreach ($arr as $dh) {
        $id = 'dahe_'.$dh['id'];
        $title = $dh['title'];
        echo $id .  "<br>";
        echo $title .  "<br>";
        if (strpos($dh['url'], 'http') === false) {
            $url = 'https://4g.dahe.cn'. $dh['url'];
        } else {
            $url = $dh['url'];
        }

//        echo $url . "<br>";
        $content = get_dahe_content($url, $num);

//        preg_match('/<h1>([\s\S]*?)<\/h1>/', $content, $head);
//        $title = $head[1];



        if (preg_match('/<section class=\"newInfo\"[\s\S]*?>([\s\S]*?)<\/section>/', $content, $matches)) {
//        print_r($matches[1]);
            $content = $matches[1];
            $content = preg_replace('/(<img[\S\s]*?src=)(\"[\S\s]*?\"[\S\s]*?data-echo=)(\"[\S\s]*?\">[\S\s]*?)/', '$1$3', $content);
            echo $content .  "<br>";
        } else {
            continue;
        }
    }


}


function get_dahe_content($url, $num) {
    $curl = curl_init();
    $setopt = array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "Accept: application/json, text/plain, */*",
            "Accept-Encoding: gzip, deflate, br",
            "Accept-Language: zh-CN,zh;q=0.9",
            "Connection: keep-alive",
            "cookie: yfx_c_g_u_id_10000007=_ck18102221561015887100072127399; yfx_mr_10000007=%3A%3Amarket_type_free_search%3A%3A%3A%3Abaidu%3A%3A%3A%3A%3A%3A%3A%3Awww.baidu.com%3A%3A%3A%3Apmf_from_free_search; yfx_mr_f_10000007=%3A%3Amarket_type_free_search%3A%3A%3A%3Abaidu%3A%3A%3A%3A%3A%3A%3A%3Awww.baidu.com%3A%3A%3A%3Apmf_from_free_search; yfx_key_10000007=; yfx_c_g_u_id_10000006=_ck18102221570512454776303704531; UM_distinctid=1669c10ec11690-05d2705708eb5e-8383268-144000-1669c10ec13881; yfx_f_l_v_t_10000006=f_t_1540216625241__r_t_1540216625241__v_t_1540219696191__r_c_0; yfx_f_l_v_t_10000007=f_t_1540216570581__r_t_1540216570581__v_t_1540221119742__r_c_0; Hm_lvt_5fb56e96c12e4012b2d8b699de81a4f5=1540219655,1540221120,1540221121,1540221151; Hm_lpvt_5fb56e96c12e4012b2d8b699de81a4f5=1540221151",
            "Host: 4g.dahe.cn",
            "Referer: https://4g.dahe.cn/index/".$num,
            "User-Agent: Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Mobile Safari/537.36",
        ),
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_SSL_VERIFYHOST => false,
    );
    curl_setopt_array($curl, $setopt);

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
        return "cURL Error #:" . $err;
    } else {
        return $response;
    }
}