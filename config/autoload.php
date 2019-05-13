<?php
spl_autoload_register(function ($class_name) {
    include(__DIR__.'/../class/'.$class_name.'.class.php');
});
