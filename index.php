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
                        <span class="material-symbols-rounded">folder_open</span>
                    </div>
                    <span class="nav-rail-label label-medium">Отчёты</span>
                </a>
                <a href="#" class="nav-rail-item ripple-target" id="tab-analytics" data-tab="analytics" role="button">
                    <div class="nav-rail-indicator">
                        <span class="material-symbols-rounded">analytics</span>
                    </div>
                    <span class="nav-rail-label label-medium">Аналитика</span>
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

            <div id="content-home" class="tab-pane">
                <header class="content-header">
                    <h1 class="headline-small">Добро пожаловать</h1>
                </header>
                <div class="content-scroll">
                    <div class="welcome-card md-card filled-card">
                        <div class="card-content">
                            <span class="material-symbols-rounded card-hero-icon">hub</span>
                            <h2 class="title-large">A-Ermakov · hub</h2>
                            <p class="body-medium">Персональная экосистема для автоматизации задач, мониторинга сервисов и аналитики данных.</p>
                        </div>
                    </div>
                    <div class="feature-list">
                        <div class="feature-item md-card elevated-card ripple-target">
                            <div class="feature-icon-container">
                                <span class="material-symbols-rounded">donut_large</span>
                            </div>
                            <div class="feature-text">
                                <span class="title-small">Аналитика журналов</span>
                                <span class="body-small secondary-text">Разбор отчётов электронного журнала и выгрузка статистики</span>
                            </div>
                            <span class="material-symbols-rounded feature-chevron">chevron_right</span>
                        </div>
                    </div>
                </div>
            </div>

            <div id="content-reports" class="tab-pane tab-hidden">

                <div id="reports-categories-root" class="submenu-level">
                    <header class="content-header">
                        <h1 class="headline-small">Категории</h1>
                    </header>
                    <div class="content-scroll">
                        <div class="list-container">
                            <div class="md-list-item ripple-target" onclick="openSubmenu('sub-reports')">
                                <div class="list-leading-icon tonal-container">
                                    <span class="material-symbols-rounded">donut_large</span>
                                </div>
                                <div class="list-content">
                                    <span class="title-medium">Отчёты</span>
                                    <span class="body-small secondary-text">Анализ журналов, статистика и учебные умения</span>
                                </div>
                                <span class="material-symbols-rounded list-trailing">chevron_right</span>
                            </div>
                            <div class="md-list-item md-list-item--disabled" onclick="">
                                <div class="list-leading-icon tonal-container tonal-container--muted">
                                    <span class="material-symbols-rounded">folder_open</span>
                                </div>
                                <div class="list-content">
                                    <span class="title-medium">Что-то ещё</span>
                                    <span class="body-small secondary-text">Дополнительные метрики и внешние выгрузки</span>
                                </div>
                                <span class="material-symbols-rounded list-trailing">chevron_right</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="sub-reports" class="submenu-level submenu-hidden">
                    <header class="content-header content-header--back">
                        <button class="icon-button ripple-target" onclick="closeSubmenu('sub-reports')" aria-label="Назад">
                            <span class="material-symbols-rounded">arrow_back</span>
                        </button>
                        <h1 class="headline-small">Отчёты по журналу</h1>
                    </header>
                    <div class="content-scroll">
                        <div class="tiles-grid">
                            <div class="md-tile active-tile ripple-target">
                                <span class="material-symbols-rounded tile-icon">donut_large</span>
                                <span class="label-small tile-label">Учебные умения</span>
                            </div>
                            <div class="md-tile disabled-tile">
                                <span class="material-symbols-rounded tile-icon">add</span>
                                <span class="label-small tile-label">Новый отчёт</span>
                            </div>
                            <div class="md-tile disabled-tile">
                                <span class="material-symbols-rounded tile-icon">add</span>
                                <span class="label-small tile-label">Новый отчёт</span>
                            </div>
                            <div class="md-tile disabled-tile">
                                <span class="material-symbols-rounded tile-icon">add</span>
                                <span class="label-small tile-label">Новый отчёт</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="sub-something-else" class="submenu-level submenu-hidden">
                    <header class="content-header content-header--back">
                        <button class="icon-button ripple-target" onclick="closeSubmenu('sub-something-else')" aria-label="Назад">
                            <span class="material-symbols-rounded">arrow_back</span>
                        </button>
                        <h1 class="headline-small">Что-то ещё</h1>
                    </header>
                    <div class="content-scroll">
                        <div class="tiles-grid">
                            <div class="md-tile disabled-tile">
                                <span class="material-symbols-rounded tile-icon">trending_up</span>
                                <span class="label-small tile-label">Метрика</span>
                            </div>
                            <div class="md-tile disabled-tile">
                                <span class="material-symbols-rounded tile-icon">add</span>
                                <span class="label-small tile-label">Добавить</span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div id="content-analytics" class="tab-pane tab-hidden">
                <header class="content-header">
                    <h1 class="headline-small">Аналитика</h1>
                </header>
                <div class="content-scroll">
                    <div class="empty-state">
                        <span class="material-symbols-rounded empty-icon">construction</span>
                        <h2 class="title-large">В разработке</h2>
                        <p class="body-medium secondary-text">Раздел на стадии проектирования модулей обработки данных.</p>
                    </div>
                </div>
            </div>

            <div id="content-settings" class="tab-pane tab-hidden">
                <header class="content-header">
                    <h1 class="headline-small">Настройки</h1>
                </header>
                <div class="content-scroll">
                    <p class="label-medium settings-section-label">Цветовая схема</p>
                    <div class="theme-chips-row">
                        <button class="theme-chip ripple-target" id="theme-btn-light" onclick="applyTheme('light')">
                            <span class="material-symbols-rounded">light_mode</span>
                            <span class="label-large">Светлая</span>
                        </button>
                        <button class="theme-chip ripple-target" id="theme-btn-dark" onclick="applyTheme('dark')">
                            <span class="material-symbols-rounded">dark_mode</span>
                            <span class="label-large">Тёмная</span>
                        </button>
                        <button class="theme-chip ripple-target" id="theme-btn-teal" onclick="applyTheme('teal')">
                            <span class="material-symbols-rounded">palette</span>
                            <span class="label-large">Бирюзовая</span>
                        </button>
                    </div>

                </div>
            </div>

        </main>
    </div>

    <script src="script.js"></script>
</body>
</html>
