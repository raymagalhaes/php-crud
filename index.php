<?php

use Ray\Crud;

use Ray\CrudException;

require 'vendor/autoload.php';

$Crud = new Crud;

$array = [
  ["name", "fullName" , "birthday"],
  ["Ray" , "Ray McLovin" , "1997-02-19"],
  ["Bond" , "James Bond" , "1953-01-01"],
  ["Jesus" , "Jesus Christ" , "0000-12-25"]
];

$notArray = "This is not an array";
echo "<pre>";
try {
    $Insert = $Crud->Insert("people", $array);
} catch (CrudException $e) {
    error_log($e);
}
echo "</pre>";
