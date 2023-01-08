<?php

namespace Iterator;

class Myiterator implements \Iterator
{
    protected $pointer;

    protected $paths;

    public function __construct($paths)
    {
        if (!file_exists($paths)) {
            echo "Такого файла не существует";
        } else {
            $row = 0;
            $fp = fopen($paths, "r");
            if ($fp) {
                while (($buffer = fgets($fp, 4096)) !== false) {
                        $this->paths[] =  str_getcsv(trim($buffer,"\n"));
                    $row++;
                }
                if (!feof($fp)) {
                    echo "Ошибка: fgets() неожиданно потерпел неудачу\n";
                }
                fclose($fp);
            }
        }
    }

    public function fromCsv($paths,$desired_row)
    {
        if ($paths) {
            $rows = -1;
            $data_csv = file($paths);
            $data = [];
            foreach ($data_csv as $row) {
                $rows++;
                if ($rows == 0 || $rows == $desired_row) {
                    $trimmed_row = trim($row, "\n");
                    $data[] = explode(',', $trimmed_row);

                }
            }
            if($rows<$desired_row || $desired_row == 0){
                echo "Указанное количество строк " . $desired_row . " больше количества строк " . $rows .  " или равно 0 в файле" . PHP_EOL;
                exit();
            }
            echo "Данные строки №" . $desired_row . ":". PHP_EOL;
            for($i=0;$i<count($data[0]);$i++){
                echo $data[0][$i] . " = " . $data[1][$i] . PHP_EOL;
            }
        }
        return $data;
    }

    public function current()
    {
        return $this->paths[$this->pointer];
    }

    public function next()
    {
        $this->pointer++;
    }

    public function key()
    {
        return $this->pointer;
    }

    public function valid()
    {
        return isset($this->paths[$this->pointer]);
    }

    public function rewind()
    {
        echo "Все данные файла: " . PHP_EOL;
        $this->pointer = 1;
    }

}
