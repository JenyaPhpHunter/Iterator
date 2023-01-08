<?php

namespace Iterator;

class Storage implements \Iterator
{
    protected $pointer;

    protected $paths;

    public function __construct($paths)
    {
        $this->paths=$paths;;
    }

    public static function fromCsv($paths,$desired_row)
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
        }
        if($rows<$desired_row || $desired_row == 0){
            echo "Указанное количество строк " . $desired_row . " больше количества строк " . $rows .  " в файле или равно 0" . PHP_EOL;
            exit();
        }
        return new static($data);
    }

    public function current()
    {
        return [$this->paths[0],$this->paths[$this->pointer],count($this->paths[0])];
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
        $this->pointer = 1;
    }

}
