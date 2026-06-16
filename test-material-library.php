<!DOCTYPE html>
<html lang="ru" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>M3 Component Library — Конструктор Хаба</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link rel="stylesheet" href="style.css">
    <style>
        .library-shell { max-width: 800px; margin: 40px auto; padding: 0 20px; }
        .component-block { margin-bottom: 48px; padding: 24px; border-radius: var(--md-sys-shape-corner-large); border: 1px solid var(--md-sys-color-outline-variant); background: var(--md-sys-color-surface-container-lowest); }
        .component-title { margin-bottom: 16px; padding-bottom: 8px; border-bottom: 1px dashed var(--md-sys-color-outline-variant); color: var(--md-sys-color-primary); }
        .flex-row { display: flex; gap: 12px; flex-wrap: wrap; align-items: center; }
    </style>
</head>
<body class="md-surface">

<div class="library-shell">
    <h1 class="md-display-medium" style="margin-bottom: 8px; font-weight: 700;">Библиотека компонентов M3</h1>
    <p class="md-body-large md-text-on-surface-variant" style="margin-bottom: 32px;">Готовые проверенные решения-кубики для сборки интерфейсов на Хабе.</p>

    <div class="component-block">
        <h3 class="md-title-large component-title">1. Кнопки (Buttons)</h3>
        <div class="flex-row">
            <button class="md-btn md-btn-filled md-ripple">
                <span class="md-icon">check</span>
                <span>Filled Button</span>
            </button>

            <button class="md-btn md-btn-tonal md-ripple">
                <span class="md-icon">add</span>
                <span>Tonal Button</span>
            </button>

            <button class="md-btn md-btn-outlined md-ripple">
                <span class="md-icon">edit</span>
                <span>Outlined</span>
            </button>

            <button class="md-btn md-btn-text md-ripple">
                <span>Text Button</span>
            </button>
        </div>
    </div>

    <div class="component-block">
        <h3 class="md-title-large component-title">2. Поля ввода (Text Fields)</h3>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 20px;">
            <div class="md-text-field md-text-field-filled">
                <input type="text" id="inp-1" placeholder=" " autocomplete="off">
                <label for="inp-1">ФИО студента</label>
            </div>

            <div class="md-text-field md-text-field-outlined">
                <input type="text" id="inp-2" placeholder=" " autocomplete="off">
                <label for="inp-2">Название класса</label>
            </div>
        </div>
    </div>

    <div class="component-block">
        <h3 class="md-title-large component-title">3. Чипы и теги (Chips)</h3>
        <div class="flex-row">
            <button class="md-chip md-chip-assist md-ripple">
                <span class="md-icon">share</span>
                <span>Поделиться</span>
            </button>

            <button class="md-chip md-chip-filter md-chip-selected md-ripple">
                <span class="md-icon">check</span>
                <span>Выбранный фильтр</span>
            </button>

            <button class="md-chip md-chip-filter md-ripple">
                <span>Обычный фильтр</span>
            </button>
        </div>
    </div>

    <div class="component-block">
        <h3 class="md-title-large component-title">4. Карточки (Cards)</h3>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 16px;">
            <div class="md-card md-card-filled" style="padding: 16px;">
                <h4 class="md-title-medium" style="font-weight:700;">Filled Card</h4>
                <p class="md-body-medium md-text-on-surface-variant" style="margin-top:4px;">Идеально для базовых блоков и фоновых контейнеров.</p>
            </div>

            <div class="md-card md-card-outlined" style="padding: 16px;">
                <h4 class="md-title-medium" style="font-weight:700;">Outlined Card</h4>
                <p class="md-body-medium md-text-on-surface-variant" style="margin-top:4px;">Отлично подходит для выделения независимых модулей.</p>
            </div>
        </div>
    </div>

    <div class="component-block">
        <h3 class="md-title-large component-title">5. Прогресс и Лоадеры (Progress)</h3>
        <div style="display: flex; flex-direction: column; gap: 24px;">
            <div class="md-progress-linear md-progress-linear-indeterminate">
                <div class="md-progress-linear-track"></div>
            </div>

            <div class="flex-row" style="justify-content: center;">
                <div class="md-progress-circular md-progress-circular-indeterminate">
                    <svg viewBox="22 22 44 44">
                        <circle class="md-progress-circular-track" cx="44" cy="44" r="20"></circle>
                        <circle class="md-progress-circular-indicator" cx="44" cy="44" r="20"></circle>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <div class="component-block">
        <h3 class="md-title-large component-title">6. Переключатели (Switch)</h3>
        <div class="flex-row">
            <label class="md-switch">
                <input type="checkbox" checked>
                <div class="md-switch-track">
                    <div class="md-switch-thumb"></div>
                </div>
                <span class="md-switch-label">Включено</span>
            </label>

            <label class="md-switch" style="margin-left: 24px;">
                <input type="checkbox">
                <div class="md-switch-track">
                    <div class="md-switch-thumb"></div>
                </div>
                <span class="md-switch-label">Выключено</span>
            </label>
        </div>
    </div>

</div>

</body>
</html>