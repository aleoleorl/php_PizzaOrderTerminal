<?php
require_once '../../src/MenuCalculator.php';

header("Content-Type: application/json; charset=UTF-8");

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$pizzaId = $_GET['pizzaId'] ?? 0;
$sizeId = $_GET['sizeId'] ?? 0;
$sauceId = $_GET['sauceId'] ?? 0;

$ret = new MenuCalculator();
echo $ret->getData($pizzaId, $sizeId, $sauceId);
?>