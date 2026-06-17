<?php
/* ==========================================================================
   UI COMPONENTS TOOLKIT & PYTHON BRIDGE (Material Design 3)
   ========================================================================== */

function renderPageHeader($title, $backFunction = null) {
    $headerClass = $backFunction ? 'content-header content-header--back' : 'content-header';
    $html = "<header class=\"{$headerClass}\">";

    if ($backFunction) {
        $html .= "<button class=\"icon-button md-ripple\" onclick=\"{$backFunction}\" aria-label=\"Назад\">
                    <span class=\"material-symbols-rounded\">arrow_back</span>
                  </button>";
    }

    $html .= "<h1 class=\"md-headline-small\">{$title}</h1></header>";
    return $html;
}

function renderListItem($icon, $title, $subtitle, $onClick = '', $isDisabled = false) {
    $itemClass = $isDisabled ? 'opacity-disabled' : 'md-list-item-clickable md-ripple';
    $clickAttr = $onClick ? "onclick=\"{$onClick}\"" : '';

    return "
    <div class=\"md-list-item {$itemClass}\" {$clickAttr}>
        <div class=\"md-list-item-leading\">
            <span class=\"material-symbols-rounded md-icon-filled md-text-primary\">{$icon}</span>
        </div>
        <div class=\"md-list-item-content list-content\">
            <span class=\"md-title-medium\">{$title}</span>
            <span class=\"md-body-small md-text-on-surface-variant\">{$subtitle}</span>
        </div>
        <span class=\"material-symbols-rounded md-list-item-trailing\">chevron_right</span>
    </div>";
}

function renderTile($icon, $label, $isActive = false, $onClick = '') {
    $statusClass = $isActive ? 'md-card-interactive md-ripple' : 'opacity-disabled';
    $clickAttr = $onClick ? "onclick=\"{$onClick}\"" : '';

    return "
    <div class=\"md-card md-card-filled card-content-center {$statusClass}\" {$clickAttr}>
        <span class=\"material-symbols-rounded md-icon-filled md-text-primary md-icon-large\">{$icon}</span>
        <span class=\"md-label-medium\">{$label}</span>
    </div>";
}

function runPythonApp($progFolder, $inputData = []) {
    $scriptPath = realpath(__DIR__ . "/../progs/{$progFolder}/main.py");
    if (!$scriptPath || !file_exists($scriptPath)) return ["status" => "error", "message" => "Программа {$progFolder} не найдена."];

    $pythonExec = realpath(__DIR__ . "/../progs/{$progFolder}/venv/bin/python");
    if (!$pythonExec || !file_exists($pythonExec)) $pythonExec = realpath(__DIR__ . "/../progs/{$progFolder}/venv/Scripts/python.exe");
    if (!$pythonExec || !file_exists($pythonExec)) {
        $isWindows = strtoupper(substr(PHP_OS, 0, 3)) === 'WIN';
        $pythonExec = $isWindows ? "python" : "python3";
    }

    $base64Args = base64_encode(json_encode($inputData, JSON_UNESCAPED_UNICODE));
    $command = "\"{$pythonExec}\" \"{$scriptPath}\" {$base64Args} 2>&1";
    $output = shell_exec($command);

    if ($output === null || trim($output) === '') return ["status" => "error", "message" => "Система вернула пустой ответ.", "raw" => null];
    $result = json_decode($output, true);
    return $result ? $result : ["status" => "error", "message" => "Текст вместо JSON.", "raw" => trim($output)];
}
?>