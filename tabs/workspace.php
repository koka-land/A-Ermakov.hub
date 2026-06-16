<div id="content-reports" class="tab-pane tab-hidden">

    <div id="reports-categories-root" class="submenu-level">
        <header class="content-header content-header--back">
            <button class="icon-button ripple-target nopointer">
                <span class="material-symbols-rounded">folder</span>
            </button>
            <h1 class="md-headline-small">Инструменты</h1>
        </header>
        <div class="content-scroll">
            <div class="md-list">

                <div class="md-list-item md-list-item-clickable md-ripple" onclick="openSubmenu('sub-reports')">
                    <div class="md-list-item-leading">
                        <span class="material-symbols-rounded md-icon-filled md-text-primary">donut_large</span>
                    </div>
                    <div class="md-list-item-content">
                        <span class="md-title-medium">Отчёты</span>
                        <span class="md-body-small md-text-on-surface-variant">Анализ журналов, статистика и учебные умения</span>
                    </div>
                    <span class="material-symbols-rounded md-list-item-trailing">chevron_right</span>
                </div>

                <div class="md-list-item opacity-disabled">
                    <div class="md-list-item-leading">
                        <span class="material-symbols-rounded md-text-on-surface-variant">folder_open</span>
                    </div>
                    <div class="md-list-item-content">
                        <span class="md-title-medium">Что-то ещё</span>
                        <span class="md-body-small md-text-on-surface-variant">Дополнительные метрики и внешние выгрузки</span>
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

<div id="universal-modal" class="md-modal-backdrop">
    <div class="md-modal-container">
        <div class="md-modal-header">
            <h2 id="universal-modal-title" class="md-headline-small">Заголовок</h2>
            <button class="icon-button modal-close-btn" onclick="closeUniversalModal()" aria-label="Закрыть">
                <span class="material-symbols-rounded">close</span>
            </button>
        </div>
        <div id="universal-modal-content" class="content-scroll"></div>
    </div>
</div>