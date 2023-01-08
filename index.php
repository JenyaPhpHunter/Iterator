<?php

require_once __DIR__ . '/vendor/autoload.php';

$paths = '/var/www/iterator/files_csv/cars.csv';
//$paths = '/var/www/iterator/files_csv/store.csv';
$desired_row = 1;

$myiterator = new \Iterator\Myiterator($paths);
$data = $myiterator->fromCsv($paths, $desired_row);
//$storage[1];
foreach ($myiterator as $value){
    echo "порядковый номер " . $value[0] . ", тип транспорта " . $value[1] . " и грузоподьемность " . $value[2] .PHP_EOL;
}


