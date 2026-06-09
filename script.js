console.log("🚀 Магия Material You: Все скрипты хаба успешно инициализированы!");

/* ==========================================================================
   1. ЛОГИКА ПЕРЕКЛЮЧЕНИЯ ОСНОВНЫХ ВКЛАДОК (ТАБОВ)
   ========================================================================== */
document.querySelectorAll('.nav-link').forEach(button => {
    button.addEventListener('click', function(e) {
        e.preventDefault();

        // Подсвечиваем только текущую активную кнопку меню
        document.querySelectorAll('.nav-link').forEach(link => link.classList.remove('active'));
        this.classList.add('active');

        const targetId = this.id.replace('tab-', 'content-');
        const targetContent = document.getElementById(targetId);

        if (targetContent) {
            // Если вкладка уже открыта — ничего не делаем
            if (!targetContent.classList.contains('noshow')) return;

            // Гасим и скрываем все остальные вкладки
            document.querySelectorAll('.tab-content').forEach(content => {
                content.classList.add('noshow');
                content.classList.remove('fade-in');
            });

            // При переключении главных вкладок сбрасываем вложенное меню до категорий
            if (typeof window.resetSubmenusToRoot === 'function') {
                window.resetSubmenusToRoot();
            }

            // Включаем целевую вкладку с эффектом плавного проявления (fade-in)
            targetContent.classList.remove('noshow');
            targetContent.classList.add('fade-in');

            // Оптимальный рендеринг анимации появления через два кадра
            requestAnimationFrame(() => {
                requestAnimationFrame(() => {
                    targetContent.classList.remove('fade-in');
                });
            });
        }
    });
});

/* ==========================================================================
   2. МНОГОУРОВНЕВАЯ НАВИГАЦИЯ ВНУТРИ ТАБА (ОТЧЁТЫ)
   ========================================================================== */

/**
 * Открывает подменю выбранной категории
 */
window.openSubmenu = function(submenuId) {
    const rootCategories = document.getElementById('reports-categories-root');
    const targetSubmenu = document.getElementById(submenuId);

    if (rootCategories && targetSubmenu) {
        rootCategories.classList.add('noshow');
        targetSubmenu.classList.remove('noshow');
    }
};

/**
 * Возвращает пользователя на один уровень назад к списку категорий
 */
window.closeSubmenu = function(submenuId) {
    const rootCategories = document.getElementById('reports-categories-root');
    const targetSubmenu = document.getElementById(submenuId);

    if (rootCategories && targetSubmenu) {
        targetSubmenu.classList.add('noshow');
        rootCategories.classList.remove('noshow');
    }
};

/**
 * Сбрасывает все подменю во вкладке "Отчёты" до базового состояния категорий
 */
window.resetSubmenusToRoot = function() {
    const rootCategories = document.getElementById('reports-categories-root');
    if (rootCategories) {
        rootCategories.classList.remove('noshow');
    }

    // Скрываем все плиточные сетки глубоких уровней
    document.querySelectorAll('.submenu-level:not(#reports-categories-root)').forEach(sub => {
        sub.classList.add('noshow');
    });
};

/* ==========================================================================
   3. ДВИЖОК ПЕРЕКЛЮЧЕНИЯ ТЕМ ОФОРМЛЕНИЯ (Material You Engine)
   ========================================================================== */

/**
 * Применяет выбранную тему к body и сохраняет её в памяти localStorage
 * @param {string} themeName - 'colorful', 'light' или 'dark'
 */
window.applyTheme = function(themeName) {
    // 1. Меняем атрибут на body — CSS мгновенно перестроит палитру переменных
    document.body.setAttribute('data-theme', themeName);

    // 2. Сохраняем выбор пользователя в кэш браузера, чтобы настройки не слетали
    localStorage.setItem('hub-preferred-theme', themeName);

    // 3. Снимаем подсветку со всех кнопок тем в настройках
    document.querySelectorAll('.theme-btn').forEach(btn => btn.classList.remove('active-theme'));

    // 4. Подсвечиваем рамкой текущую выбранную плитку темы
    const activeBtn = document.getElementById(`theme-btn-${themeName}`);
    if (activeBtn) {
        activeBtn.classList.add('active-theme');
    }
};

// ИНИЦИАЛИЗАЦИЯ: Автоматически восстанавливаем тему при первой загрузке страницы
document.addEventListener('DOMContentLoaded', () => {
    const savedTheme = localStorage.getItem('hub-preferred-theme') || 'colorful';
    window.applyTheme(savedTheme);
});