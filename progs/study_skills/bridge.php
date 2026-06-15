<?php
// Профессиональный PHP-мост между браузером и локальным Flask (порт 5000)
$flask_url = "http://127.0.0.1:5000";

$action = $_GET['action'] ?? '';

// 1. Обработка запроса статистики визитов через cURL
if ($action === 'stats') {
    $ch = curl_init($flask_url . '/');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        http_response_code(500);
        echo "ERROR: Flask server is offline on port 5000. " . curl_error($ch);
    } else {
        echo $response;
    }

    curl_close($ch);
    exit;
}

// 2. Обработка отправки файла на анализ
if ($action === 'analyze' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_FILES['csv_file'])) {
        http_response_code(400);
        echo "ERROR: No file uploaded to PHP bridge.";
        exit;
    }

    $ch = curl_init($flask_url . '/analyze');
    $cfile = new CURLFile(
        $_FILES['csv_file']['tmp_name'],
        $_FILES['csv_file']['type'],
        $_FILES['csv_file']['name']
    );

    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, ['csv_file' => $cfile]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        http_response_code(500);
        echo "ERROR: Failed to connect to Flask: " . curl_error($ch);
    } else {
        echo $response;
    }

    curl_close($ch);
    exit;
}

http_response_code(400);
echo "Bad Request";