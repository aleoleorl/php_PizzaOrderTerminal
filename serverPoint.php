<?php
require_once 'src/dbHandle.php';
require_once 'src/dbExchange.php';

header("Content-Type: application/json; charset=UTF-8");

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$request = $_GET['request'] ?? '';

switch ($request)
{
	case 'menu':	
		$database = new Database();
		$db = $database->getConnection();
		$ret = new MenuPizza($db);
		echo $ret->getData();
		break;
	case 'calccost': 
		$pizzaId = $_GET['pizzaId'] ?? 0;
		$sizeId = $_GET['sizeId'] ?? 0;
		$sauceId = $_GET['sauceId'] ?? 0;
		
		$database = new Database();
		$db = $database->getConnection();
		
		$ret = new MenuCalculator($db);
		echo $ret->getData($pizzaId, $sizeId, $sauceId);
		break;
	case 'checkorder': 
		$pizzaId = $_GET['pizzaId'] ?? '';
		$sizeId = $_GET['sizeId'] ?? '';
		$sauceId = $_GET['sauceId'] ?? '';
		$prePrice = $_GET['prePrice'] ?? '';
		$currency = $_GET['currency'] ?? '';
		
		$database = new Database();
		$db = $database->getConnection();

		$ret = new OrderChecker($db);
		echo $ret->getData($pizzaId, $sizeId, $sauceId, $prePrice, $currency);
		break;
	default:
		echo json_encode(["message" => "Invalid request"]);
		break;
}
?>