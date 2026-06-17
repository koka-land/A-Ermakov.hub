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
    initTypingEffect();
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