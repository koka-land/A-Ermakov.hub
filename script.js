/* =============================================================================
   A-Ermakov · hub — Material You script (Updated Scope)
   ============================================================================= */

document.addEventListener('DOMContentLoaded', () => {
    // Восстанавливаем тему до отрисовки интерфейса
    const saved = localStorage.getItem('hub-theme') || 'light';
    applyTheme(saved);

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
    // Обновляем состояние подсветки кнопок рельса
    document.querySelectorAll('.nav-rail-item').forEach(i => i.classList.remove('active'));
    const navItem = document.getElementById(`tab-${tabName}`);
    if (navItem) navItem.classList.add('active');

    // Смена видимых панелей
    document.querySelectorAll('.tab-pane').forEach(p => p.classList.add('tab-hidden'));
    const pane = document.getElementById(`content-${tabName}`);
    if (!pane) return;

    void pane.offsetWidth;
    pane.classList.remove('tab-hidden');

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

    // Снимаем класс со всех чипов и ставим его только текущему выбранному элементу
    document.querySelectorAll('.md-chip-filter').forEach(c => c.classList.remove('active'));
    const btn = document.getElementById(`theme-btn-${theme}`);
    if (btn) btn.classList.add('active');
};

/* --------------------------------------------------------------------------
   Universal Modal Window Controller
   -------------------------------------------------------------------------- */
window.openProgramModal = async (title, progFolder) => {
    const modal = document.getElementById('universal-modal');
    const titleEl = document.getElementById('universal-modal-title');
    const contentEl = document.getElementById('universal-modal-content');

    if (!modal || !contentEl) return;

    document.body.classList.add('modal-open');
    titleEl.innerText = title;
    modal.style.display = 'flex';
    contentEl.innerHTML = `
        <div style="display:flex; justify-content:center; padding:48px 0;">
            <div class="md-progress-circular md-progress-circular-indeterminate">
                <svg viewBox="0 0 48 48">
                    <circle class="md-progress-circular-indicator" cx="24" cy="24" r="20"/>
                </svg>
            </div>
        </div>`;

    try {
        const response = await fetch(`ui_render.php?prog=${progFolder}`);
        const html = await response.text();
        contentEl.innerHTML = html;

        // Инициализируем скрипты загруженного подмодуля
        const scripts = contentEl.querySelectorAll('script');
        scripts.forEach(oldScript => {
            const newScript = document.createElement('script');
            newScript.setAttribute('data-modal-script', progFolder); // метим всегда
            if (oldScript.src) {
                newScript.src = oldScript.src;
            } else {
                newScript.textContent = oldScript.textContent;
            }
            document.body.appendChild(newScript);
            oldScript.remove();
        });
    } catch (e) {
        contentEl.innerHTML = '<p class="md-text-error" style="text-align:center; padding:24px;">Не удалось загрузить интерфейс модуля.</p>';
    }
};

window.closeUniversalModal = () => {
    const modal = document.getElementById('universal-modal');
    const contentEl = document.getElementById('universal-modal-content');
    if (modal) {
        modal.style.display = 'none';
        contentEl.innerHTML = '';
        document.body.classList.remove('modal-open');
        document.querySelectorAll('[data-modal-script]').forEach(s => s.remove());
    }
};

/* --------------------------------------------------------------------------
   PWA Installation Engine
   -------------------------------------------------------------------------- */
let deferredPrompt = null;
window.addEventListener('beforeinstallprompt', (e) => {
    e.preventDefault();
    deferredPrompt = e;

    const isDismissed = sessionStorage.getItem('pwa-notice-dismissed');
    const pwaNotice = document.getElementById('pwa-notice');

    if (pwaNotice && !isDismissed) {
        setTimeout(() => {
            pwaNotice.classList.add('show');
        }, 2000);
    }
});

document.addEventListener('DOMContentLoaded', () => {
    const pwaNotice = document.getElementById('pwa-notice');
    const installBtn = document.getElementById('pwa-install-btn');

    if (!pwaNotice || !installBtn) return;

    const isStandalone = window.matchMedia('(display-mode: standalone)').matches || navigator.standalone;
    const isDismissed = sessionStorage.getItem('pwa-notice-dismissed');

    const isIOS = /iPhone|iPad|iPod/i.test(navigator.userAgent);
    if (isIOS && !isStandalone && !isDismissed) {
        setTimeout(() => {
            pwaNotice.classList.add('show');
        }, 3000);
    }

    installBtn.addEventListener('click', async () => {
        if (deferredPrompt) {
            deferredPrompt.prompt();
            const { outcome } = await deferredPrompt.userChoice;
            if (outcome === 'accepted') {
                dismissPwaNotice();
            }
            deferredPrompt = null;
        } else {
            if (/iPhone|iPad|iPod/i.test(navigator.userAgent)) {
                alert('Чтобы установить приложение на iOS:\n\n1. Нажмите кнопку «Поделиться» (квадрат со стрелкой вверх) на панели Safari.\n2. Выберите пункт «На экран Домой» (+).');
            } else {
                alert('Чтобы запустить полноэкранный режим, откройте меню браузера и нажмите «Установить» или «Добавить на главный экран».');
            }
        }
    });
});

window.dismissPwaNotice = () => {
    const pwaNotice = document.getElementById('pwa-notice');
    if (pwaNotice) {
        pwaNotice.classList.remove('show');
        sessionStorage.setItem('pwa-notice-dismissed', 'true');
    }
};