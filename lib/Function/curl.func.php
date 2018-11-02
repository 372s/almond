<?php

/**
 * @param $url
 * @return string
 */
function curl_get($url) {
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
    // curl_setopt($curl, CURLOPT_HEADER, false);
    $output = curl_exec($curl);
    // $error = curl_error($curl);
    curl_close($curl);
    return $output;
}

function curl_post($url, $data = array(), $headers = array()) {
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
    // curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
    $output = curl_exec($curl);
    $error = curl_error($curl);
    curl_close($curl);
    return $output;
}

function curl_request_h($url, $method = 'GET', $params = array(), $headers = array()) {
    $params = http_build_query($params);
    $curl = curl_init();
    switch (strtoupper($method)) {
        case 'GET':
            if (!empty($params)) {
                $url .= (strpos($url, '?') ? '&' : '?') . $params;
            }
            curl_setopt($curl, CURLOPT_HTTPGET, true);
            break;
        case 'POST':
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $params);
            break;
        case 'PUT':
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'PUT');
            curl_setopt($curl, CURLOPT_POSTFIELDS, $params);
            break;
        case 'DELETE':
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'DELETE');
            curl_setopt($curl, CURLOPT_POSTFIELDS, $params);
            break;
    }
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
    // curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    $response = curl_exec($curl);
    $error = curl_error($curl);
    curl_close($curl);
    return $response;
}