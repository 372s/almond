<?php
/**
 * Created by PhpStorm.
 * User: wangqiang
 * Date: 2018/10/16
 * Time: 15:32
 */
header("Content-type: text/html; charset=utf-8");

function curl_get_content($url) {
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
            "Accept: */*",
            "Accept-Encoding: gzip, deflate",
            "Accept-Language: zh-CN,zh;q=0.9",
            "Connection: keep-alive",
            "cookie: JSESSIONID=ca9cb4217619f6fa9cb9e1fb0251a25d6dcbe0fcb6b42f722731319d9f936e04; wuid=858333728975137; wuid_createAt=2018-10-17 21:21:13; UM_distinctid=166822ff75f2d9-0578cdeefa5cce-8383268-144000-166822ff760efc; weather_auth=2; Hm_lvt_15fafbae2b9b11d280c79eff3b840e45=1539782473,1539794706,1539868279,1540048374; CNZZDATA1255169715=2039961635-1539782310-%7C1540047523; fingerprint=njeLBO5agsBvgrdOZ3lR1539782477780; captcha=s%3A70c213df5e8ec148dd7b5989c4303f68.wkM14EjvN4aQw1i49E9UpZd5kVk4i0tVXy4D65nW4cU; cn_1255169715_dplus=%7B%22distinct_id%22%3A%20%22166822ff75f2d9-0578cdeefa5cce-8383268-144000-166822ff760efc%22%2C%22sp%22%3A%20%7B%22%24_sessionid%22%3A%200%2C%22%24_sessionTime%22%3A%201540052105%2C%22%24dp%22%3A%200%2C%22%24_sessionPVTime%22%3A%201540052105%7D%7D; Hm_lpvt_15fafbae2b9b11d280c79eff3b840e45=1540052129",
            "Host: www.yidianzixun.com",
            "Referer: http://www.yidianzixun.com/",
            "User-Agent: Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Mobile Safari/537.36",
            'X-Requested-With: XMLHttpRequest',
        ),
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

function filter($content, $words = array()) {
    $ret = false;
    foreach ($words as $ft) {
        if (stripos($content, $ft) !== false) {
            $ret = true;
            break;
        }
    }
    return $ret;
}

function miltime() {
    list($s1, $s2) = explode(' ', microtime());
    return (float)sprintf('%.0f', (floatval($s1) + floatval($s2)) * 1000);
}