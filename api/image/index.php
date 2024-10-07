<?php
require_once '../../src/ImageHandler.php';

header("Content-Type: application/json; charset=UTF-8");

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$imageName = $_GET['image'] ?? '';
$imageHandler = new ImageHandler(__DIR__ . '/../../img');
$imageUrl = $imageHandler->getImageUrl($imageName);

if ($imageUrl) 
{
    echo json_encode(['imageUrl' => $imageUrl]);
} 
else 
{
    http_response_code(404);
    echo json_encode(['error' => 'Image not found']);
}
?>