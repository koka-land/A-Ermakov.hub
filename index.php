<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>A-Ermakov.hub</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>

    <div class="container">

        <div id="logo">
            <h1 class="logo">hub</h1>
        </div>

        <div class="leftbox">
            <nav>
                <a id="tab-home" class="nav-link active" title="Главная"><i class="fa fa-user"></i></a>
                <a id="tab-payment" class="nav-link" title="Оплата"><i class="fa fa-credit-card"></i></a>
                <a id="tab-subscription" class="nav-link" title="Подписки"><i class="fa fa-tv"></i></a>
                <a id="tab-settings" class="nav-link" title="Настройки"><i class="fa fa-cog"></i></a>
            </nav>
        </div>

        <div class="rightbox">

            <div id="content-home" class="tab-content">
                <h1 class="page-title">Отчеты по электронному журналу</h1>

                <div class="grid-layout">
    <a href="/cgi-bin/app.cgi" class="tile-card tile-blue">
    <div class="tile-inside">
        <div class="tile-icon">
            <i class="fa-solid fa-chart-pie"></i> </div>
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

            <div id="content-payment" class="tab-content noshow">
                <h1 class="page-title">Информация об оплате</h1>
                <p class="placeholder-text">Здесь будет модуль биллинга...</p>
            </div>

            <div id="content-subscription" class="tab-content noshow">
                <h1 class="page-title">Ваши подписки</h1>
                <p class="placeholder-text">Управление активными лицензиями и планами.</p>
            </div>

            <div id="content-settings" class="tab-content noshow">
                <h1 class="page-title">Настройки системы</h1>
                <p class="placeholder-text">Конфигурация параметров персонального хаба.</p>
            </div>

        </div>
    </div>

    <script src="script.js"></script>
</body>
</html>