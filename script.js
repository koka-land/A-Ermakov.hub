/* =============================================================================
   A-Ermakov · hub — Material You script
   ============================================================================= */

document.addEventListener('DOMContentLoaded', () => {
    // Restore theme before anything renders
    const saved = localStorage.getItem('hub-theme') || 'light';
    applyTheme(saved);

    initRipple();
    initNavRail();
    dismissLoader();
});

/* --------------------------------------------------------------------------
   Loader
   -------------------------------------------------------------------------- */
function dismissLoader() {
    const loader = document.getElementById('app-loader');
    if (!loader) return;
    setTimeout(() => {
        loader.classList.add('fade-out');
        setTimeout(() => loader.remove(), 420);
    }, 900);
}

/* --------------------------------------------------------------------------
   Navigation Rail
   -------------------------------------------------------------------------- */
function initNavRail() {
    document.querySelectorAll('.nav-rail-item').forEach(item => {
        item.addEventListener('click', e => {
            e.preventDefault();
            switchTab(item.dataset.tab);
        });
    });
}

function switchTab(tabName) {
    // Update rail active state
    document.querySelectorAll('.nav-rail-item').forEach(i => i.classList.remove('active'));
    const navItem = document.getElementById(`tab-${tabName}`);
    if (navItem) navItem.classList.add('active');

    // Swap visible pane
    document.querySelectorAll('.tab-pane').forEach(p => p.classList.add('tab-hidden'));
    const pane = document.getElementById(`content-${tabName}`);
    if (!pane) return;

    // Force reflow so transition plays even when switching to same pane
    void pane.offsetWidth;
    pane.classList.remove('tab-hidden');

    // Reset submenus on reports tab switch
    if (tabName === 'reports') resetSubmenusToRoot();
}

/* --------------------------------------------------------------------------
   Submenus (Reports tab)
   -------------------------------------------------------------------------- */
window.openSubmenu = function(id) {
    const root = document.getElementById('reports-categories-root');
    const target = document.getElementById(id);
    if (!root || !target) return;

    root.classList.add('submenu-hidden');
    target.classList.remove('submenu-hidden');

    // Re-trigger CSS animation
    target.style.animation = 'none';
    void target.offsetWidth;
    target.style.animation = '';
};

window.closeSubmenu = function(id) {
    const root = document.getElementById('reports-categories-root');
    const target = document.getElementById(id);
    if (!root || !target) return;

    target.classList.add('submenu-hidden');
    root.classList.remove('submenu-hidden');

    root.style.animation = 'none';
    void root.offsetWidth;
    root.style.animation = '';
};

window.resetSubmenusToRoot = function() {
    const root = document.getElementById('reports-categories-root');
    if (root) root.classList.remove('submenu-hidden');
    document.querySelectorAll('.submenu-level:not(#reports-categories-root)').forEach(s => {
        s.classList.add('submenu-hidden');
    });
};

/* --------------------------------------------------------------------------
   Theme Engine
   -------------------------------------------------------------------------- */
window.applyTheme = function(theme) {
    document.documentElement.setAttribute('data-theme', theme);
    document.body.setAttribute('data-theme', theme);
    localStorage.setItem('hub-theme', theme);

    document.querySelectorAll('.theme-chip').forEach(c => c.classList.remove('active'));
    const btn = document.getElementById(`theme-btn-${theme}`);
    if (btn) btn.classList.add('active');
};

/* --------------------------------------------------------------------------
   Ripple Effect (M3 state layer)
   -------------------------------------------------------------------------- */
function initRipple() {
    document.addEventListener('pointerdown', e => {
        const target = e.target.closest('.ripple-target');
        if (!target || target.classList.contains('md-list-item--disabled')) return;
        if (target.tagName === 'A' && target.classList.contains('nav-rail-item')) return;

        const rect = target.getBoundingClientRect();
        const d = Math.max(target.clientWidth, target.clientHeight) * 2.5;
        const ripple = document.createElement('span');
        ripple.className = 'ripple';
        Object.assign(ripple.style, {
            width:  `${d}px`,
            height: `${d}px`,
            left:   `${e.clientX - rect.left  - d / 2}px`,
            top:    `${e.clientY - rect.top   - d / 2}px`,
        });
        target.appendChild(ripple);
        ripple.addEventListener('animationend', () => ripple.remove(), { once: true });
    });
}

// Открытие любого интерфейса в универсальном окне
window.openProgramModal = async (title, progFolder) => {
    const modal = document.getElementById('universal-modal');
    const titleEl = document.getElementById('universal-modal-title');
    const contentEl = document.getElementById('universal-modal-content');

    if (!modal || !contentEl) return;
// === ВКЛЮЧАЕМ РЕЖИМ МОДАЛЬНОГО ОКНА ДЛЯ CSS ===
    document.body.classList.add('modal-open');
    // =============================================
    // 1. Ставим заголовок и открываем шторку
    titleEl.innerText = title;
    modal.style.display = 'flex';
    contentEl.innerHTML = '<p style="text-align:center; color:var(--md-sys-color-outline);">Загрузка компонента...</p>';

    try {
        // 2. Асинхронно запрашиваем ui.php у сервера
        const response = await fetch(`ui_render.php?prog=${progFolder}`);
        const html = await response.text();

        // 3. Вставляем разметку
        contentEl.innerHTML = html;

        // 4. Магия: заставляем работать <script> теги внутри загруженного ui.php
        const scripts = contentEl.querySelectorAll('script');
        scripts.forEach(oldScript => {
            const newScript = document.createElement('script');
            if (oldScript.src) {
                newScript.src = oldScript.src;
            } else {
                newScript.textContent = oldScript.textContent;
            }
            document.body.appendChild(newScript);
            oldScript.remove(); // убираем дубликат
        });
    } catch (e) {
        contentEl.innerHTML = '<p style="color:var(--md-sys-color-error);">Не удалось загрузить интерфейс.</p>';
    }
};

// Сброс и закрытие
window.closeUniversalModal = () => {
    const modal = document.getElementById('universal-modal');
    const contentEl = document.getElementById('universal-modal-content');
    if (modal) {
        modal.style.display = 'none';
        // ПОЛНЫЙ СБРОС: Стираем контент из DOM-дерева.
        // При следующем открытии всё загрузится девственно чистым, без старых инпутов и результатов!
        contentEl.innerHTML = '';
// === ВЫКЛЮЧАЕМ РЕЖИМ МОДАЛЬНОГО ОКНА ДЛЯ CSS ===
        document.body.classList.remove('modal-open');
        // =============================================
    }
};
// Умный показ уведомления о PWA
document.addEventListener('DOMContentLoaded', () => {
    const pwaNotice = document.getElementById('pwa-notice');
    if (!pwaNotice) return;

    // 1. Проверяем, мобильное ли это устройство
    const isMobile = /Android|iPhone|iPad|iPod/i.test(navigator.userAgent);

    // 2. Проверяем, запущено ли оно уже в режиме Standalone (как приложение с экрана Домой)
    const isStandalone = window.matchMedia('(display-mode: standalone)').matches || navigator.standalone;

    // 3. Проверяем, не скрывал ли пользователь этот баннер ранее в этой сессии
    const isDismissed = sessionStorage.getItem('pwa-notice-dismissed');

    // Если это мобилка, приложение ЕЩЕ НЕ установлено и баннер не закрывали — показываем его
    if (isMobile && !isStandalone && !isDismissed) {
        pwaNotice.style.display = 'flex';
    } else {
        pwaNotice.style.display = 'none'; // На ПК или внутри PWA баннер спать не будет
    }
});

// Функция закрытия баннера
window.dismissPwaNotice = () => {
    const pwaNotice = document.getElementById('pwa-notice');
    if (pwaNotice) {
        pwaNotice.style.display = 'none';
        // Запоминаем, что пользователь закрыл его, чтобы не спамить при переходе по вкладкам
        sessionStorage.setItem('pwa-notice-dismissed', 'true');
    }
};
// Умный показ уведомления о PWA с задержкой
document.addEventListener('DOMContentLoaded', () => {
    const pwaNotice = document.getElementById('pwa-notice');
    if (!pwaNotice) return;

    const isMobile = /Android|iPhone|iPad|iPod/i.test(navigator.userAgent);
    const isStandalone = window.matchMedia('(display-mode: standalone)').matches || navigator.standalone;
    const isDismissed = sessionStorage.getItem('pwa-notice-dismissed');

    // Если условия подходят — взводим таймер
    if (isMobile && !isStandalone && !isDismissed) {
        // Окно мягко выедет через 3 секунды (3000 миллисекунд) после загрузки сайта
        setTimeout(() => {
            pwaNotice.classList.add('show');
        }, 3000);
    }
});

// Красивое скрытие баннера
window.dismissPwaNotice = () => {
    const pwaNotice = document.getElementById('pwa-notice');
    if (pwaNotice) {
        // Сначала убираем класс, чтобы баннер плавно уехал вниз
        pwaNotice.classList.remove('show');
        
        // Запоминаем выбор пользователя на время этой сессии
        sessionStorage.setItem('pwa-notice-dismissed', 'true');
    }
};
