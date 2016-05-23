<?php

$json = preg_split('/\n/', file_get_contents('lista.csv'));
$json = array_map(function ($line) {
    return explode(',', $line);
}, $json);
$json = array_filter($json, function ($line) {
    return array_key_exists(2, $line) && !!$line[2];
});
$json = array_map('array_values', $json);
$json = array_map(function ($line) {
    return "{$line[1]} - {$line[2]} ${line[3]}";
}, $json);

$random = mt_rand(0, count($json));

$param = isset($argv[1]) ? $argv[1] : false;
if ($param && strtolower($param) === 'all') {
    fwrite(STDOUT, implode("\r\n", $json));
    return;
}

fwrite(STDOUT, $json[$random]);