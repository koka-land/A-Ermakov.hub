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

document.addEventListener('DOMContentLoaded', () => {
    const runBtn = document.getElementById('run-py-btn');
    const textInput = document.getElementById('py-text-input');
    const resultCard = document.getElementById('py-result-card');
    const resultContent = document.getElementById('py-result-content');

    if (runBtn) {
        runBtn.addEventListener('click', async () => {
            const textValue = textInput.value.trim();
            if (!textValue) {
                alert('Пожалуйста, введите текст');
                return;
            }

            // Визуальный фидбек: меняем текст на кнопке во время расчета
            runBtn.innerHTML = `<span class="material-symbols-rounded spinning">autorenew</span> Считаем...`;
            runBtn.style.opacity = '0.7';

            try {
                // Отправляем AJAX запрос в наш PHP обработчик
                const response = await fetch('run_handler.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({
                        prog: 'hello_python',
                        params: { text: textValue }
                    })
                });

                const result = await response.json();

                if (result.status === 'success') {
                    // Формируем красивый вывод данных из Python
                    resultContent.innerHTML = `
                        <p><strong>Оригинал:</strong> ${result.data.original}</p>
                        <p><strong>В верхнем регистре:</strong> <span style="color: var(--md-sys-color-secondary); font-weight: bold;">${result.data.uppercase}</span></p>
                        <hr style="border: 0; border-top: 1px solid var(--md-sys-color-outline-variant); my: 8px;">
                        <p><strong>Всего символов:</strong> ${result.data.stats.chars}</p>
                        <p><strong>Количество слов:</strong> ${result.data.stats.words}</p>
                    `;
                    resultCard.style.display = 'block';
                } else {
                    resultContent.innerHTML = `<p style="color: var(--md-sys-color-error);">Ошибка: ${result.message}</p>`;
                    resultCard.style.display = 'block';
                }
            } catch (error) {
                resultContent.innerHTML = `<p style="color: var(--md-sys-color-error);">Критическая ошибка связи с сервером.</p>`;
                resultCard.style.display = 'block';
            } finally {
                // Возвращаем кнопку в исходное состояние
                runBtn.innerHTML = `<span class="material-symbols-rounded">play_arrow</span> Запустить Python`;
                runBtn.style.opacity = '1';
            }
        });
    }
});