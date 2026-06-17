<?php require_once 'includes/components.php'; ?>
<!DOCTYPE html>
<html lang="ru" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>A-Ermakov · hub</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet">
    <link rel="stylesheet" href="css/themes.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/components.css">
</head>
<body>

    <div id="app-loader" class="app-loader">
    <div class="loader-content">
        <div class="md-progress-circular">
            <svg viewBox="0 0 48 48" class="progress-svg">
                <circle class="md-progress-circular-track" cx="24" cy="24" r="20"/>
                <circle class="md-progress-circular-indicator" cx="24" cy="24" r="20"/>
            </svg>
        </div>
        <span class="md-label-large loader-label">hub</span>
    </div>
</div>

    <div class="app-surface" id="app">

        <nav class="nav-rail" role="navigation" aria-label="Основная навигация">
            <div class="nav-rail-header">
                <span class="nav-brand">hub</span>
            </div>
            <div class="nav-rail-items">
                <a href="#" class="nav-rail-item active md-ripple" id="tab-home" data-tab="home" role="button">
                    <div class="nav-rail-indicator">
                        <span class="material-symbols-rounded">home</span>
                    </div>
                    <span class="nav-rail-label md-label-medium">Главная</span>
                </a>
                <a href="#" class="nav-rail-item md-ripple" id="tab-reports" data-tab="reports" role="button">
                    <div class="nav-rail-indicator">
                        <span class="material-symbols-rounded">design_services</span>
                    </div>
                    <span class="nav-rail-label md-label-medium">Инструменты</span>
                </a>
                <a href="#" class="nav-rail-item md-ripple" id="tab-settings" data-tab="settings" role="button">
                    <div class="nav-rail-indicator">
                        <span class="material-symbols-rounded">settings</span>
                    </div>
                    <span class="nav-rail-label md-label-medium">Настройки</span>
                </a>
            </div>
        </nav>

        <main class="content-area" role="main">

            <div id="pwa-notice">
    <span class="material-symbols-rounded pwa-lead-icon">touch_app</span>
    <div class="pwa-content">
        <h4 class="md-title-small pwa-title">Приложение готово к установке</h4>
        <p class="md-body-small pwa-text">
            Запускайте прямо с экрана «Домой» во весь экран и без лишних панелей браузера.
        </p>
        <button id="pwa-install-btn" class="md-btn md-btn-tonal md-ripple pwa-btn">
            <span class="material-symbols-rounded md-icon-small">download</span>
            Установить
        </button>
    </div>
    <button class="icon-button pwa-close-btn" onclick="dismissPwaNotice()" aria-label="Закрыть">
        <span class="material-symbols-rounded">close</span>
    </button>
</div>

            <?php include 'tabs/home.php'; ?>
            <?php include 'tabs/workspace.php'; ?>
            <?php include 'tabs/settings.php'; ?>
        <div id="universal-modal" class="md-modal-backdrop">
            <div class="md-modal-container">
                <div class="md-modal-header">
                    <h2 id="universal-modal-title" class="md-headline-small">Заголовок</h2>
                    <button class="icon-button modal-close-btn" onclick="closeUniversalModal()" aria-label="Закрыть">
                        <span class="material-symbols-rounded">close</span>
                    </button>
                </div>
                <div id="universal-modal-content" class="content-scroll"></div>
            </div>
        </div>

    </main>
</div>

<script src="script.js"></script>
</body>
</html>