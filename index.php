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
                <a id="tab-home" class="nav-link active" title="Главная"><i class="fa-solid fa-house"></i></a>
                <a id="tab-reports" class="nav-link" title="Отчёты"><i class="fa-solid fa-folder-closed"></i></a>
            </nav>
        </div>

        <div class="rightbox">

            <div id="content-home" class="tab-content">
                <h1 class="page-title">Добро пожаловать в A-Ermakov.hub</h1>

                <div class="hub-welcome-text">
                    <p><strong>A-Ermakov.hub</strong> — это единая персональная экосистема для автоматизации рутинных задач, мониторинга сервисов и аналитики данных.</p>

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
                <h1 class="page-title">Отчеты по электронному журналу</h1>

                <div class="grid-layout">
                    <a href="/cgi-bin/app.cgi" class="tile-card tile-blue">
                        <div class="tile-inside">
                            <div class="tile-icon">
                                <i class="fa-solid fa-chart-pie"></i>
                            </div>
                            <span class="tile-title">Оценка учебных умений</span>
                        </div>
                    </a>

                    <div class="tile-card empty-service">
                        <div class="tile-inside">
                            <div class="tile-icon">
                                <i class="fa-solid fa-chart-line"></i>
                            </div>
                            <span class="tile-title">Новый отчёт</span>
                        </div>
                    </div>

                    <div class="tile-card empty-service">
                        <div class="tile-inside">
                            <div class="tile-icon">
                                <i class="fa-solid fa-chart-line"></i>
                            </div>
                            <span class="tile-title">Новый отчёт</span>
                        </div>
                    </div>

                    <div class="tile-card empty-service">
                        <div class="tile-inside">
                            <div class="tile-icon">
                                <i class="fa-solid fa-chart-line"></i>
                            </div>
                            <span class="tile-title">Новый отчёт</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script src="script.js"></script>
</body>
</html>