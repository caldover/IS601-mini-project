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

class system {

    public static function printPage($page) {
        echo $page;
    }

}