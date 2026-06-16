<?php
ini_set('display_errors', 0);
error_reporting(E_ALL);

header('Content-Type: application/json; charset=utf-8');

require_once 'includes/components.php';

$requestBody = file_get_contents('php://input');
$data = json_decode($requestBody, true);

if (!$data || !isset($data['prog']) || !isset($data['params'])) {
    echo json_encode(["status" => "error", "message" => "Неверные параметры запроса."]);
    exit;
}

$result = runPythonApp($data['prog'], $data['params']);
echo json_encode($result, JSON_UNESCAPED_UNICODE);