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

        // Process opening HTML boilerplate
        html::generateHTMLOpening($htmlOutput);

        $htmlOutput .= '<table class="table table-striped">';
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

        // Process closing HTML boilerplate
        html::generateHTMLClosing($htmlOutput);

        // Print generated table
        print $htmlOutput;
    }

    private static function generateTableHeader($fields, &$htmlOutput) {
        $htmlOutput .= '<thead><tr>';
        foreach($fields as $field) {
            $htmlOutput .= "<th scope='col'>{$field}</th>";
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

    private static function generateHTMLOpening(&$htmlOutput) {
        $htmlOutput .= '<!doctype html>
                            <html lang="en">
                                <head>
                                    <!-- Required meta tags -->
                                    <meta charset="utf-8">
                                    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

                                    <!-- Bootstrap CSS -->
                                    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
                                
                                    <title>IS601 Bootstrap Assignment</title>
                                  </head>
                                
                                  <body>';
    }

    private static function generateHTMLClosing(&$htmlOutput) {
        $htmlOutput .=              '<!-- Optional JavaScript -->
                                    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
                                    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
                                    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
                                    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
                                  </body>
                            </html>';
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