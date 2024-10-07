<?php
require_once '../../src/OrderChecker.php';

header("Content-Type: application/json; charset=UTF-8");

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$pizzaId = $_GET['pizzaId'] ?? '';
$sizeId = $_GET['sizeId'] ?? '';
$sauceId = $_GET['sauceId'] ?? '';
$prePrice = $_GET['prePrice'] ?? '';
$currency = $_GET['currency'] ?? '';

$ret = new OrderChecker();
echo $ret->getData($pizzaId, $sizeId, $sauceId, $prePrice, $currency);
?>