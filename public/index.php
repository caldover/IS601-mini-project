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

class Automobile {

    private $vehicleMake;
    private $vehicleModel;
    public function __construct($make, $model) {
        $this->vehicleMake = $make;
        $this->vehicleModel = $model;
    }
    public function getMakeAndModel() {
        return $this->vehicleMake . ' ' . $this->vehicleModel;
    }

}
class AutomobileFactory {

    public static function create($make, $model) {
        return new Automobile($make, $model);
    }

}