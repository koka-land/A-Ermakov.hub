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
// Переменная для хранения нативного промиса установки (Chrome / Android)
let deferredPrompt = null;

// 1. ПЕРЕХВАТ СИСТЕМНОГО СОБЫТИЯ (Работает в Android/Chrome/Edge)
window.addEventListener('beforeinstallprompt', (e) => {
    // Блокируем дефолтное всплывающее окно браузера
    e.preventDefault();
    // Сохраняем событие в нашу переменную
    deferredPrompt = e;

    // Если устройство мобильное и баннер не был скрыт вручную — активируем показ
    const isDismissed = sessionStorage.getItem('pwa-notice-dismissed');
    const pwaNotice = document.getElementById('pwa-notice');

    if (pwaNotice && !isDismissed) {
        setTimeout(() => {
            pwaNotice.classList.add('show');
        }, 2000); // Показываем через 2 секунды после готовности
    }
});

// 2. ЛОГИКА ДЛЯ УСТРОЙСТВ, ГДЕ СОБЫТИЕ НЕ ПОДДЕРЖИВАЕТСЯ (Например, iOS Safari)
document.addEventListener('DOMContentLoaded', () => {
    const pwaNotice = document.getElementById('pwa-notice');
    const installBtn = document.getElementById('pwa-install-btn');

    if (!pwaNotice || !installBtn) return;

    const isMobile = /Android|iPhone|iPad|iPod/i.test(navigator.userAgent);
    const isStandalone = window.matchMedia('(display-mode: standalone)').matches || navigator.standalone;
    const isDismissed = sessionStorage.getItem('pwa-notice-dismissed');

    // Хитрый ход для iOS Safari: так как события 'beforeinstallprompt' там нет,
    // мы принудительно взводим таймер баннера вручную только для техники Apple
    const isIOS = /iPhone|iPad|iPod/i.test(navigator.userAgent);
    if (isIOS && !isStandalone && !isDismissed) {
        setTimeout(() => {
            pwaNotice.classList.add('show');
        }, 3000);
    }

    // КЛИК ПО КНОПКЕ «УСТАНОВИТЬ»
    installBtn.addEventListener('click', async () => {
        // Сценарий А: Есть системный промис (Android / Chrome)
        if (deferredPrompt) {
            // Вызываем родное системное окно установки
            deferredPrompt.prompt();

            // Ждем, что ответит пользователь
            const { outcome } = await deferredPrompt.userChoice;
            if (outcome === 'accepted') {
                console.log('Пользователь установил PWA хаб!');
                dismissPwaNotice(); // Прячем баннер
            }
            deferredPrompt = null;
        }
        // Сценарий Б: Нативного промиса нет (iOS / Safari)
        else {
            if (/iPhone|iPad|iPod/i.test(navigator.userAgent)) {
                // Красиво и кастомно объясняем пользователю Apple, что делать
                alert('Чтобы установить приложение на iOS:\n\n1. Нажмите кнопку «Поделиться» (квадрат со стрелкой вверх) на нижней панели браузера Safari.\n2. В открывшемся меню выберите пункт «На экран Домой» (+).');
            } else {
                // Заглушка для ПК или редких браузеров
                alert('Чтобы запустить полноэкранный режим, откройте главное меню вашего браузера и нажмите «Установить» или «Добавить на главный экран».');
            }
        }
    });
});

// Плавное скрытие баннера
window.dismissPwaNotice = () => {
    const pwaNotice = document.getElementById('pwa-notice');
    if (pwaNotice) {
        pwaNotice.classList.remove('show');
        sessionStorage.setItem('pwa-notice-dismissed', 'true');
    }
};