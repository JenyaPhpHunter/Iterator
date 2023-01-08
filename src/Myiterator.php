<?php

namespace Iterator;

class Myiterator implements \Iterator, \ArrayAccess
{
    protected $pointer;

    protected $paths;

    protected array $data = [];

    public function __construct($paths)
    {
        $this->paths = $paths;
        if (!file_exists($paths)) {
            echo "Такого файла не существует";
        } else {
            $row = 0;
            $fp = fopen($paths, "r");
            if ($fp) {
                while (($buffer = fgets($fp, 4096)) !== false) {
                        $this->data[] =  str_getcsv(trim($buffer,"\n"));
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
        return $this->data[$this->pointer];
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
        return isset($this->data[$this->pointer]);
    }

    public function rewind()
    {
        echo "Все данные файла: " . PHP_EOL;
        $this->pointer = 1;
    }

    public function offsetExists($offset)
    {
        return isset($this->data[$offset]);
    }

    public function offsetGet($offset)
    {
        if($offset < count($this->data) && $offset>0){
            return $this->data[$offset];
        } else {
            echo "такой строки нет в файле" . PHP_EOL;
        }

    }

    public function offsetSet($offset, $value)
    {
        if ($offset === null || $offset >= count($this->data)) {
            $offset = count($this->data);
            $this->data[$offset] = $value;
            $fp = fopen($this->paths, 'w');
            foreach ($this->data as $rows) {
                fputcsv($fp, $rows);
            }
            fclose($fp);
        }
        elseif ($offset < count($this->data) && $offset > 0){
            for($i=0;$i<count($this->data);$i++) {
                if ($i == $offset) {
                    $this->data[$offset] = $value;
                }
            }
            $fp = fopen($this->paths, 'w');
            foreach ($this->data as $rows) {
                fputcsv($fp, $rows);
            }
            fclose($fp);
        } else {
            echo "Ваш индекс меньше нуля" . PHP_EOL;
        }
    }

    public function offsetUnset($offset)
    {
        if($offset < 1){
            echo "Вы ввели неправильный индекс" . PHP_EOL;
        } else {
            for ($i = 0; $i < count($this->data); $i++) {
                if ($i == $offset) {
                    unset($this->data[$offset]);
                }
            }
            $fp = fopen($this->paths, 'w');
            foreach ($this->data as $rows) {
                fputcsv($fp, $rows);
            }
            fclose($fp);
        }
    }
}
