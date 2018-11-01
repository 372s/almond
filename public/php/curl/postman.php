<?php

function get($url, $params = array(), $headers = array(), $refer = '')
{
    $curl = curl_init();
    if (count($params)) {
        $url = $url . '?' . http_build_query($params);
    }
    curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => $headers,
        CURLOPT_REFERER => 'http://m.medlive.test/mymedlive/invite_setinfo.php',
    ));
    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
        return "cURL Error #:" . $err;
    } else {
        return $response;
    }
}

function post($url, $params)
{
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => http_build_query($params),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
        echo "cURL Error #:" . $err;
    } else {
        echo $response;
    }
}

function curl_post($url, $data)
{
    $ch = curl_init();
    curl_setopt_array($ch, array(
        CURLOPT_URL => $url,
        CURLOPT_POST => true,
        // CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => http_build_query($data),
        CURLOPT_RETURNTRANSFER => true,
    ));
    $output = curl_exec($ch);
    $error = curl_error($ch);
    curl_close($ch);
    if ($output === false) {
        $output = array('error' => 'ERROR: ' . $error);
    } else {
        $output = ['code' => "$output"];
    }
    return $output;
}

function curlPost($url, $data)
{
    $ch = curl_init(); //初始化
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    $output = curl_exec($ch);
    $error = curl_error($ch);
    curl_close($ch);
    if ($output === false) {
        $output = array('error' => $error);
    }
    return $output;
}

// var_dump(curlPost('http://sms-cly.cn/sendData.do?', array(
//     'username' => 'clyymt',
//     'password' => '55b4bfec5492cf0aadfe8f1ec2962781',
//     'mobile' => '18612651314,13733822332',
//     'content' => '您的验证码是465654【医脉通】,您的验证码是132131【医脉通】',
//     'dstime' => '',
//     'ext'=> '',
//     'msgid'=> ''
// )));

print_r(curlPost('http://api.medlive.test/sms/report.php', array(
    'report' => '18612651314|DELIVRD|1049207374241983489|78084|2018-10-08 15:58:28')
));
