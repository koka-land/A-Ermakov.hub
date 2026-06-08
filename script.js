console.log("🚀 Новый скрипт хаба успешно загружен и выполнен!");

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
   2. МНОГОУРОВНЕВАЯ НАВИГАЦИЯ (Экспорт в window для onclick в HTML)
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