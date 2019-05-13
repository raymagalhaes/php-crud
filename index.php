<?php
include(__DIR__.'/config/autoload.php');
$Crud = Crud::getInstance();
$Where = [":id" => 1 , ":name" => "John"];
$getPeople = $Crud->Select("people", "name", $Where);
echo "<pre>";
print_r($getPeople);
echo "</pre>";
