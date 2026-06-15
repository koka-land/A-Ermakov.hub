<?php require_once 'includes/components.php'; ?>
<!DOCTYPE html>
<html lang="ru" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>A-Ermakov · hub</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&family=Space+Grotesk:wght@700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div id="app-loader" class="app-loader">
        <div class="loader-content">
            <div class="md-circular-progress">
                <svg viewBox="0 0 48 48" class="progress-svg">
                    <circle class="progress-track" cx="24" cy="24" r="20"/>
                    <circle class="progress-indicator" cx="24" cy="24" r="20"/>
                </svg>
            </div>
            <span class="label-large loader-label">hub</span>
        </div>
    </div>

    <div class="app-surface" id="app">

        <nav class="nav-rail" role="navigation" aria-label="Основная навигация">
            <div class="nav-rail-header">
                <span class="nav-brand title-medium">hub</span>
            </div>
            <div class="nav-rail-items">
                <a href="#" class="nav-rail-item active ripple-target" id="tab-home" data-tab="home" role="button">
                    <div class="nav-rail-indicator">
                        <span class="material-symbols-rounded">home</span>
                    </div>
                    <span class="nav-rail-label label-medium">Главная</span>
                </a>
                <a href="#" class="nav-rail-item ripple-target" id="tab-reports" data-tab="reports" role="button">
                    <div class="nav-rail-indicator">
                        <span class="material-symbols-rounded">design_services</span>
                    </div>
                    <span class="nav-rail-label label-medium">Инструменты</span>
                </a>
                <a href="#" class="nav-rail-item ripple-target" id="tab-settings" data-tab="settings" role="button">
                    <div class="nav-rail-indicator">
                        <span class="material-symbols-rounded">settings</span>
                    </div>
                    <span class="nav-rail-label label-medium">Настройки</span>
                </a>
            </div>
        </nav>
        <main class="content-area" role="main">
            <div id="pwa-notice">
    <span class="material-symbols-rounded pwa-lead-icon">touch_app</span>

    <div class="pwa-content">
        <h4 class="title-small pwa-title">Приложение готово к установке</h4>
        <p class="body-small pwa-text">
            Запускайте прямо с экрана «Домой» во весь экран и без лишних панелей браузера.
        </p>

        <button id="pwa-install-btn" class="ripple-target">
            <span class="material-symbols-rounded">download</span>
            Установить
        </button>
    </div>

    <button class="pwa-close-btn" onclick="dismissPwaNotice()" aria-label="Закрыть">
        <span class="material-symbols-rounded">close</span>
    </button>
</div>
            <?php include 'tabs/home.php'; ?>
            <?php include 'tabs/workspace.php'; ?>
            <?php include 'tabs/settings.php'; ?>
        </main>
    </div>

    <script src="script.js"></script>
</body>
</html>
