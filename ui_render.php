<?php
// Шлюз для динамической отдачи интерфейсов программ
header('Content-Type: text/html; charset=utf-8');

$prog = $_GET['prog'] ?? '';

// Защита: разрешаем только безопасные символы
if (!preg_match('/^[a-zA-Z0-9_-]+$/', $prog)) {
    echo "<p class='md-body-medium md-text-error'>Неверное имя программы.</p>";
    exit;
}

$uiPath = __DIR__ . "/progs/{$prog}/ui.php";

if (file_exists($uiPath)) {
    include $uiPath;
} else {
    echo "<p class='md-body-medium md-text-error'>Интерфейс программы не найден.</p>";
}