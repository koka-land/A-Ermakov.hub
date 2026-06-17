<div id="content-reports" class="tab-pane tab-hidden">

    <div id="reports-categories-root" class="submenu-level">
        <header class="content-header content-header--back">
            <button class="icon-button ripple-target nopointer">
                <span class="material-symbols-rounded">folder</span>
            </button>
            <h1 class="md-headline-small">Инструменты</h1>
        </header>
        <div class="content-scroll">
            <div class="md-list" style="display: flex; flex-direction: column; gap: 8px;">

    <div class="md-list-item md-card-outlined md-list-item-clickable md-ripple" onclick="openSubmenu('sub-reports')">
        <div class="md-list-item-leading tonal-container" style="width: 40px; height: 40px; border-radius: 20px; display: flex; align-items: center; justify-content: center; background: var(--md-sys-color-secondary-container);">
            <span class="material-symbols-rounded md-icon-filled md-text-primary">donut_large</span>
        </div>
        <div class="md-list-item-content list-content">
            <span class="md-title-medium">Отчёты</span>
            <span class="md-body-small secondary-text">Анализ журналов, статистика и учебные умения</span>
        </div>
        <span class="material-symbols-rounded md-list-item-trailing">chevron_right</span>
    </div>

    <div class="md-list-item md-card-outlined opacity-disabled" onclick="">
        <div class="md-list-item-leading tonal-container--muted" style="width: 40px; height: 40px; border-radius: 20px; display: flex; align-items: center; justify-content: center; background: var(--md-sys-color-surface-container-highest);">
            <span class="material-symbols-rounded md-text-on-surface-variant">folder_open</span>
        </div>
        <div class="md-list-item-content list-content">
            <span class="md-title-medium">Что-то ещё</span>
            <span class="md-body-small secondary-text">Дополнительные метрики и внешние выгрузки</span>
        </div>
        <span class="material-symbols-rounded md-list-item-trailing">chevron_right</span>
    </div>

</div>
        </div>
    </div>

    <div id="sub-reports" class="submenu-level submenu-hidden">
        <header class="content-header content-header--back">
            <button class="icon-button ripple-target" onclick="closeSubmenu('sub-reports')" aria-label="Назад">
                <span class="material-symbols-rounded">arrow_back</span>
            </button>
            <h1 class="md-headline-small">Отчёты по журналу</h1>
        </header>
        <div class="content-scroll">
            <div class="grid-responsive-small">

                <div class="md-card md-card-filled md-card-interactive md-ripple card-content-center" onclick="openProgramModal('Учебные умения', 'study_skills')">
                    <span class="material-symbols-rounded md-icon-filled md-text-primary md-icon-large">donut_large</span>
                    <span class="md-label-medium">Учебные умения</span>
                </div>
            </div>
        </div>
    </div>
</div>