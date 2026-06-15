<?php
// Профессиональный PHP-мост между браузером и локальным Flask (порт 8000)
$flask_url = "http://127.0.0.1:5000";

$action = $_GET['action'] ?? '';

// 1. Обработка запроса статистики визитов
if ($action === 'stats') {
    // PHP сам делает внутренний запрос во Flask (этому запросу файрволы не мешают)
    $html = @file_get_contents($flask_url . '/');
    if ($html === false) {
        http_response_code(500);
        echo "ERROR: Flask server is offline on port 8000";
        exit;
    }
    echo $html;
    exit;
}

// 2. Обработка отправки файла на анализ
if ($action === 'analyze' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_FILES['csv_file'])) {
        http_response_code(400);
        echo "ERROR: No file uploaded to PHP bridge.";
        exit;
    }

    // Пересылаем полученный CSV-файл во Flask через cURL
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