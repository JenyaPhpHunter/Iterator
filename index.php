<?php

require_once __DIR__ . '/vendor/autoload.php';

$paths = '/var/www/iterator/files_csv/cars.csv';
//$paths = '/var/www/iterator/files_csv/store.csv';
$desired_row = 1;

$storage = new \Iterator\Storage($paths);
$data = $storage->fromCsv($paths, $desired_row);
//$storage[1];
foreach ($data as $value){
    for($i=0;$i<$value[2];$i++){
        echo $value[0][$i] . " = " . $value[1][$i] . PHP_EOL;
    }
}

