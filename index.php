<?php

require_once __DIR__ . '/vendor/autoload.php';

$paths = '/var/www/iterator/files_csv/cars.csv';
//$paths = '/var/www/iterator/files_csv/store.csv';
$desired_row = 1;

$myiterator = new \Iterator\Myiterator($paths);
$data = $myiterator->fromCsv($paths, $desired_row);
foreach ($myiterator as $value) {
    echo "порядковый номер " . $value[0] . ", тип транспорта " . $value[1] . " и грузоподьемность " . $value[2] . PHP_EOL;
}
print_r($myiterator[1]);
$myiterator[2] = ["2", "moto", "1"];   // заменяет вторую строку csv файла
if (!isset($myiterator[5])) {
    $myiterator[4] = ["4", "moto", "1"];  // добавляет строку в конец файла
}
unset($myiterator[4]);  // удаляет строку из файла


