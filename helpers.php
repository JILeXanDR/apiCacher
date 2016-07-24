<?php

require_once 'app/Cache.php';

function dd()
{
    var_dump(func_get_args());
    exit;
}

function toJson($data) : string
{
    header('Content-Type: application/json; charset=utf-8');

    echo json_encode($data);
    exit;
}

/**
 * @param string $url
 * @param string $method
 * @param array|null $postData
 * @return stdClass
 */
function makeRequestOrGetFromCache(string $url, string $method = 'GET', array $postData = null) : stdClass
{
    $ch = curl_init();

    $data = [
        'isCachedResult' => false
    ];

    $cache = new Cache();

    $response = [];

    $requestId = md5($url . json_encode($postData));

    $cachedResultString = $cache->get($requestId);

    if (empty($cachedResultString)) {
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, $method === 'POST' ? 1 : 0);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);

        $jsonResponse = curl_exec($ch);

        $response = json_decode($jsonResponse, true);

        curl_close($ch);

        $cache->put($requestId, json_encode([
            'request' => [
                'url' => $url,
                'method' => $method,
                'body' => $postData,
            ],
            'response' => json_decode($jsonResponse, true)
        ]));

    } else {
        $data['isCachedResult'] = true;
        $cachedResult = json_decode($cachedResultString, true);
        $response = $cachedResult['response'];
    }


    $data['response'] = $response;

    return (object)$data;
}