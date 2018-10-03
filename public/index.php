<?php

main::start();

class main {

    public static function start() {
        $records = csv::getRecords();
        $table = html::generateTable($records);
        system::printPage($table);
    }

}

class csv {

    public static function getRecords($filename) {
        $file = fopen($filename, "r");
        $fieldNames = array();
        $count = 0;
        while(!feof($file)) {
            $record = fgetcsv($file);
            if($count == 0) {
                $fieldNames = $record;
            } else {
                $records[] = recordFactory::create($fieldNames, $record);
            }
            $count++;
        }
        fclose($file);
        return $records;
    }

}

class html {

    public static function generateTable($records) {
        $table = $records;
        return $table;
    }

}

class record {
    public function __construct(Array $fieldNames = null, $values = null) {
        $record = array_combine($fieldNames, $values);
        foreach($record as $property => $value) {
            $this->createProperty($property, $value);
        }
    }

    public function createProperty($name = 'first', $value = 'keith') {
        $this->{$name} = $value;
    }

    public function returnArray() {
        $array = (array) $this;
        return $array;
    }
}

class recordFactory {

    public static function create(Array $fieldNames = null, Array $values = null) {
        $record = new record($fieldNames, $values);
        return $record;
    }
    
}