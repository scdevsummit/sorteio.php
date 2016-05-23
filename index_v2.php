<?php

use Sergiors\Functional as F;

require_once __DIR__.'/vendor/autoload.php';

$contents = F\compose(F\partial('preg_split', '/\n/'), 'file_get_contents');

$ls = (new F\Collection($contents('lista.csv')))
    ->map(function ($line) {
        return explode(',', $line);
    })->filter(function ($line) {
        return array_key_exists(2, $line) && !!$line[2];
    })->map(function ($line) {
        return "{$line[1]} - {$line[2]} ${line[3]}";
    });

$random = mt_rand(0, $ls->count());

$param = isset($argv[1]) ? $argv[1] : false;
if ($param && strtolower($param) === 'all') {
    fwrite(STDOUT, implode("\r\n", $ls->toArray()));
    return;
}

fwrite(STDOUT, $ls->toArray()[$random]);
