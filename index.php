<?php

ini_set('display_errors', true);
error_reporting(E_ALL);
header('Access-Control-Allow-Origin: *');

$config = require_once 'config.php';
require_once 'helpers.php';

$url = $config['proxiedApiUrl'] . $_SERVER['REQUEST_URI'];

$data = makeRequestOrGetFromCache($url, $_SERVER['REQUEST_METHOD'], $_POST);

header(join(':', ['From-Cache', json_encode($data->isCachedResult)]));

toJson($data->response);