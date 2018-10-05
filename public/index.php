<?php

// start program
main::start("example.csv");

class main {

    public static function start($filename) {
        $records = csv::getRecords($filename);
        $table = html::generateTable($records); // currently only prints array contents

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
        $count = 0;
        $htmlOutput = '';

        $htmlOutput .= '<table>';
        foreach($records as $record) {
            if($count == 0) {
                $array = $record->returnArray();
                $fields = array_keys($array);
                $values = array_values($array);
                //print_r($fields);
                //print_r($values);

                // Process table header
                html::generateTableHeader($fields, $htmlOutput);

                // Begin processing table body
                $htmlOutput .= '<tbody>';
                html::generateTableRow($values, $htmlOutput);
            } else {
                $array = $record->returnArray();
                $values = array_values($array);
                //print_r($values);
                // Process table row within body
                html::generateTableRow($values, $htmlOutput);
            }
            $count++;
        }
        $htmlOutput .= '</tbody></table>';


        // Print generated table
        print $htmlOutput;
    }

    private static function generateTableHeader($fields, &$htmlOutput) {
        $htmlOutput .= '<thead><tr>';
        foreach($fields as $field) {
            $htmlOutput .= "<th>{$field}</th>";
        }
        $htmlOutput .= '</tr></thead>';
    }

    private static function generateTableRow($values, &$htmlOutput) {
        $htmlOutput .= '<tr>';
        foreach($values as $value) {
            $htmlOutput .= "<td>{$value}</td>";
        }
        $htmlOutput .= '</tr>';
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