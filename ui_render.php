<?php
// Шлюз для динамической отдачи интерфейсов программ
header('Content-Type: text/html; charset=utf-8');

$prog = $_GET['prog'] ?? '';

// Защита: разрешаем только безопасные символы в имени папки (без точек и слэшей)
if (!preg_match('/^[a-zA-Z0-9_.-]+$/', $prog)) {
    echo "<p style='color:var(--md-sys-color-error);'>Неверное имя программы.</p>";
    exit;
}

$uiPath = __DIR__ . "/progs/{$prog}/ui.php";

if (file_exists($uiPath)) {
    include $uiPath;
} else {
    echo "<p style='color:var(--md-sys-color-error);'>Интерфейс программы не найден.</p>";
}