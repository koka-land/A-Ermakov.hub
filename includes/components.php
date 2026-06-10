<?php
/* ==========================================================================
   UI COMPONENTS TOOLKIT & PYTHON BRIDGE (Material Design 3)
   ========================================================================== */

/**
 * 1. Шаблон заголовка страницы
 */
function renderPageHeader($title, $backFunction = null) {
    $headerClass = $backFunction ? 'content-header content-header--back' : 'content-header';
    $html = "<header class=\"{$headerClass}\">";

    if ($backFunction) {
        $html .= "<button class=\"icon-button ripple-target\" onclick=\"{$backFunction}\" aria-label=\"Назад\">
                    <span class=\"material-symbols-rounded\">arrow_back</span>
                  </button>";
    }

    $html .= "<h1 class=\"headline-small\">{$title}</h1></header>";
    return $html;
}

/**
 * 2. Шаблон элемента списка (Категории)
 */
function renderListItem($icon, $title, $subtitle, $onClick = '', $isDisabled = false) {
    $itemClass = $isDisabled ? 'md-list-item--disabled' : 'ripple-target';
    $containerClass = $isDisabled ? 'tonal-container--muted' : '';
    $clickAttr = $onClick ? "onclick=\"{$onClick}\"" : '';

    return "
    <div class=\"md-list-item {$itemClass}\" {$clickAttr}>
        <div class=\"list-leading-icon tonal-container {$containerClass}\">
            <span class=\"material-symbols-rounded\">{$icon}</span>
        </div>
        <div class=\"list-content\">
            <span class=\"title-medium\">{$title}</span>
            <span class=\"body-small secondary-text\">{$subtitle}</span>
        </div>
        <span class=\"material-symbols-rounded list-trailing\">chevron_right</span>
    </div>";
}

/**
 * 3. Шаблон плитки
 */
function renderTile($icon, $label, $isActive = false, $onClick = '') {
    $statusClass = $isActive ? 'active-tile ripple-target' : 'disabled-tile';
    $clickAttr = $onClick ? "onclick=\"{$onClick}\"" : '';

    return "
    <div class=\"md-tile {$statusClass}\" {$clickAttr}>
        <span class=\"material-symbols-rounded tile-icon\">{$icon}</span>
        <span class=\"label-small tile-label\">{$label}</span>
    </div>";
}

/**
 * 4. УНИВЕРСАЛЬНЫЙ МОСТ ДЛЯ ЗАПУСКА PYTHON (Base64 канал)
 */
function runPythonApp($progFolder, $inputData = []) {
    $scriptPath = realpath(__DIR__ . "/../progs/{$progFolder}/main.py");

    if (!$scriptPath || !file_exists($scriptPath)) {
        return ["status" => "error", "message" => "Программа {$progFolder} не найдена."];
    }

    // Ищем виртуальное окружение (Linux / Alt Linux)
    $pythonExec = realpath(__DIR__ . "/../progs/{$progFolder}/venv/bin/python");

    // Если мы на Windows (локальная разработка в PyCharm)
    if (!$pythonExec || !file_exists($pythonExec)) {
        $pythonExec = realpath(__DIR__ . "/../progs/{$progFolder}/venv/Scripts/python.exe");
    }

    // Если venv вообще не создан, берем системные бинарники
    if (!$pythonExec || !file_exists($pythonExec)) {
        $isWindows = strtoupper(substr(PHP_OS, 0, 3)) === 'WIN';
        $pythonExec = $isWindows ? "python" : "python3";
    }

    // Кодируем параметры в Base64, чтобы защитить структуру JSON от экранирования терминалов
    $base64Args = base64_encode(json_encode($inputData, JSON_UNESCAPED_UNICODE));

    // Формируем команду с перенаправлением потока ошибок (2>&1)
    $command = "\"{$pythonExec}\" \"{$scriptPath}\" {$base64Args} 2>&1";

    // Запускаем
    $output = shell_exec($command);

    if ($output === null || trim($output) === '') {
        return [
            "status" => "error",
            "message" => "Система вернула пустой ответ от Python.",
            "raw" => null
        ];
    }

    // Пробуем декодировать ответ
    $result = json_decode($output, true);

    return $result ? $result : [
        "status" => "error",
        "message" => "Python вернул текст вместо JSON-строки.",
        "raw" => trim($output)
    ];
}
?>