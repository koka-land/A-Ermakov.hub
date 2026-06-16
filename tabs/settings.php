<div id="content-settings" class="tab-pane tab-hidden">
    <header class="content-header">
        <h1 class="md-headline-small">Настройки</h1>
    </header>
    <div class="content-scroll">
        <p class="md-label-medium md-text-primary section-label">Цветовая схема</p>

        <div class="theme-chips-row flex-wrap-gap-8">
            <button class="md-chip md-chip-filter md-ripple" id="theme-btn-light" onclick="applyTheme('light')">
                <span class="material-symbols-rounded md-icon-small">light_mode</span>
                <span class="md-label-large">Светлая</span>
            </button>

            <button class="md-chip md-chip-filter md-ripple" id="theme-btn-dark" onclick="applyTheme('dark')">
                <span class="material-symbols-rounded md-icon-small">dark_mode</span>
                <span class="md-label-large">Тёмная</span>
            </button>

            <button class="md-chip md-chip-filter md-ripple" id="theme-btn-vivid-light" onclick="applyTheme('vivid-light')">
                <span class="material-symbols-rounded md-icon-small">light_mode</span>
                <span class="md-label-large">Vivid светлая</span>
            </button>

            <button class="md-chip md-chip-filter md-ripple" id="theme-btn-vivid-dark" onclick="applyTheme('vivid-dark')">
                <span class="material-symbols-rounded md-icon-small">dark_mode</span>
                <span class="md-label-large">Vivid тёмная</span>
            </button>

            <button class="md-chip md-chip-filter md-ripple" id="theme-btn-bubble-light" onclick="applyTheme('bubble-light')">
                <span class="material-symbols-rounded md-icon-small">light_mode</span>
                <span class="md-label-large">Bubble светлая</span>
            </button>

            <button class="md-chip md-chip-filter md-ripple" id="theme-btn-bubble-dark" onclick="applyTheme('bubble-dark')">
                <span class="material-symbols-rounded md-icon-small">dark_mode</span>
                <span class="md-label-large">Bubble тёмная</span>
            </button>

        </div>
    </div>
</div>