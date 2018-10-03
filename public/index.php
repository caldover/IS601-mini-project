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

    public static function getRecords() {

        $make = 'Subaru';
        $model = 'WRX';
        $car = AutomobileFactory::create($make, $model);

        //$records = 'test';

        $records[] = $car;
        print_r($records);
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