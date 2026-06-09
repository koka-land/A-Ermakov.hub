<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>A-Ermakov.hub</title>
    <link class="style" rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>

    <div class="container">

        <div id="logo">
            <h1 class="logo">hub</h1>
        </div>

        <div class="leftbox">
            <nav>
                <a href="#" class="nav-link active" id="tab-home" data-tooltip="Главная">
                    <i class="fa fa-home" aria-hidden="true"></i>
                </a>
                <a href="#" class="nav-link" id="tab-reports" data-tooltip="Отчёты ЭЖ">
                    <i class="fa fa-folder-open" aria-hidden="true"></i>
                </a>
                <a href="#" class="nav-link" id="tab-analytics" data-tooltip="Аналитика">
                    <i class="fa fa-bar-chart" aria-hidden="true"></i>
                </a>
                <a href="#" class="nav-link" id="tab-settings" data-tooltip="Настройки">
                    <i class="fa fa-cog" aria-hidden="true"></i>
                </a>
            </nav>
        </div>

        <div class="rightbox">

            <div id="content-home" class="tab-content">
                <h1 class="page-title">Добро пожаловать в A-Ermakov.hub</h1>
                <div class="hub-welcome-text">
                    <p><strong>A-Ermakov.hub</strong> — это единая персональная экосистема для автоматизации рутинных задач, monitoring-а сервисов и аналитики данных.</p>
                    <h2 class="sub-title">Что доступно в системе:</h2>
                    <ul class="hub-features-list">
                        <li>
                            <i class="fa-solid fa-chart-pie"></i>
                            <div>
                                <strong>Аналитика журналов</strong>
                                <span>Автоматический разбор отчётов электронного журнала, оценка учебных умений и выгрузка статистики. (Вкладка «Отчёты»)</span>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>

            <div id="content-reports" class="tab-content noshow">

                <div id="reports-categories-root" class="submenu-level">
                    <div class="back-button-row placeholder">
                        <i class="fa-solid fa-arrow-left-long"></i> Назад в категории
                    </div>
                    <h1 class="page-title">Категории аналитики</h1>
                    <div class="categories-grid">
                        <div class="category-card tile-blue" onclick="openSubmenu('sub-reports')">
                            <div class="category-icon-wrapper">
                                <i class="fa-solid fa-chart-pie"></i>
                            </div>
                            <div class="category-info">
                                <h2>Отчёты</h2>
                                <p>Анализ журналов, выгрузка статистики и учебные умения</p>
                            </div>
                            <i class="fa-solid fa-chevron-right arrow-next"></i>
                        </div>
                        <div class="category-card empty-service" onclick="openSubmenu('sub-something-else')">
                            <div class="category-icon-wrapper">
                                <i class="fa-solid fa-folder-open"></i>
                            </div>
                            <div class="category-info">
                                <h2>Что-то еще</h2>
                                <p>Дополнительные метрики, архивы и внешние выгрузки данных</p>
                            </div>
                            <i class="fa-solid fa-chevron-right arrow-next"></i>
                        </div>
                    </div>
                </div>

                <div id="sub-reports" class="submenu-level noshow">
                    <div class="back-button-row" onclick="closeSubmenu('sub-reports')">
                        <i class="fa-solid fa-arrow-left-long"></i> Назад в категории
                    </div>
                    <h1 class="page-title">Отчёты по электронному журналу</h1>
                    <div class="grid-layout">
                        <div class="tile-card tile-blue">
                            <i class="fa-solid fa-chart-pie tile-icon"></i>
                            <span class="tile-title">Оценка учебных умений</span>
                        </div>
                        <div class="tile-card empty-service">
                            <i class="fa-solid fa-plus tile-icon"></i>
                            <span class="tile-title">Новый отчёт</span>
                        </div>
                        <div class="tile-card empty-service">
                            <i class="fa-solid fa-plus tile-icon"></i>
                            <span class="tile-title">Новый отчёт</span>
                        </div>
                        <div class="tile-card empty-service">
                            <i class="fa-solid fa-plus tile-icon"></i>
                            <span class="tile-title">Новый отчёт</span>
                        </div>
                    </div>
                </div>

                <div id="sub-something-else" class="submenu-level noshow">
                    <div class="back-button-row" onclick="closeSubmenu('sub-something-else')">
                        <i class="fa-solid fa-arrow-left-long"></i> Назад в категории
                    </div>
                    <h1 class="page-title">Что-то еще</h1>
                    <div class="grid-layout">
                        <div class="tile-card empty-service">
                            <i class="fa-solid fa-chart-line tile-icon"></i>
                            <span class="tile-title">Какая-то метрика</span>
                        </div>
                        <div class="tile-card empty-service">
                            <i class="fa-solid fa-plus tile-icon"></i>
                            <span class="tile-title">Добавить блок</span>
                        </div>
                    </div>
                </div>

            </div> <div id="content-analytics" class="tab-content noshow">
                <div class="back-button-row placeholder">
                    <i class="fa-solid fa-arrow-left-long"></i> Заглушка
                </div>
                <h1 class="page-title">Глобальная аналитика</h1>
                <p style="padding-left: 40px; font-weight: 300; color: var(--md-sys-color-on-surface-muted);">Раздел находится на стадии проектирования модулей обработки данных.</p>
            </div>

            <div id="content-settings" class="tab-content noshow">
                <div class="back-button-row placeholder">
                    <i class="fa-solid fa-arrow-left-long"></i> Заглушка
                </div>
                <h1 class="page-title">Настройки оформления</h1>
                <div class="theme-options-grid">
                    <div class="theme-btn" id="theme-btn-colorful" onclick="applyTheme('colorful')">
                        <i class="fa-solid fa-palette"></i>
                        <span>Цветная</span>
                    </div>
                    <div class="theme-btn" id="theme-btn-light" onclick="applyTheme('light')">
                        <i class="fa-solid fa-sun"></i>
                        <span>Светлая</span>
                    </div>
                    <div class="theme-btn" id="theme-btn-dark" onclick="applyTheme('dark')">
                        <i class="fa-solid fa-moon"></i>
                        <span>Тёмная</span>
                    </div>
                </div>
            </div> </div> </div> <script src="script.js"></script>
</body>
</html>