<?php
require_once '../../src/MenuPizza.php';

header("Content-Type: application/json; charset=UTF-8");

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$ret = new MenuPizza();
echo $ret->getData();
?>