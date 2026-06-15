<div id="content-reports" class="tab-pane tab-hidden">

                <div id="reports-categories-root" class="submenu-level">
                    <header class="content-header content-header--back">
                        <button class="icon-button ripple-target nopointer">
                            <span class="material-symbols-rounded">folder</span>
                        </button>
                        <h1 class="headline-small">Инструменты</h1>
                    </header>
                    <div class="content-scroll">
                        <div class="list-container">
                            <div class="md-list-item ripple-target" onclick="openSubmenu('sub-reports')">
                                <div class="list-leading-icon tonal-container">
                                    <span class="material-symbols-rounded">donut_large</span>
                                </div>
                                <div class="list-content">
                                    <span class="title-medium">Отчёты</span>
                                    <span class="body-small secondary-text">Анализ журналов, статистика и учебные умения</span>
                                </div>
                                <span class="material-symbols-rounded list-trailing">chevron_right</span>
                            </div>
                            <div class="md-list-item md-list-item--disabled" onclick="">
                                <div class="list-leading-icon tonal-container tonal-container--muted">
                                    <span class="material-symbols-rounded">folder_open</span>
                                </div>
                                <div class="list-content">
                                    <span class="title-medium">Что-то ещё</span>
                                    <span class="body-small secondary-text">Дополнительные метрики и внешние выгрузки</span>
                                </div>
                                <span class="material-symbols-rounded list-trailing">chevron_right</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="sub-reports" class="submenu-level submenu-hidden">
                    <header class="content-header content-header--back">
                        <button class="icon-button ripple-target" onclick="closeSubmenu('sub-reports')" aria-label="Назад">
                            <span class="material-symbols-rounded">arrow_back</span>
                        </button>
                        <h1 class="headline-small">Отчёты по журналу</h1>
                    </header>
                    <div class="content-scroll">
                        <div class="tiles-grid">
                            <div class="md-tile active-tile ripple-target" onclick="openProgramModal('Учебные умения', 'study_skills')">
                                <span class="material-symbols-rounded tile-icon">donut_large</span>
                                <span class="label-small tile-label">Учебные умения</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="sub-something-else" class="submenu-level submenu-hidden">
                    <header class="content-header content-header--back">
                        <button class="icon-button ripple-target" onclick="closeSubmenu('sub-something-else')" aria-label="Назад">
                            <span class="material-symbols-rounded">arrow_back</span>
                        </button>
                        <h1 class="headline-small">Что-то ещё</h1>
                    </header>
                    <div class="content-scroll">
                        <div class="tiles-grid">
                            <div class="md-tile disabled-tile">
                                <span class="material-symbols-rounded tile-icon">trending_up</span>
                                <span class="label-small tile-label">Метрика</span>
                            </div>
                            <div class="md-tile disabled-tile">
                                <span class="material-symbols-rounded tile-icon">add</span>
                                <span class="label-small tile-label">Добавить</span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

<div id="universal-modal" class="md-modal-backdrop">
    <div class="md-modal-container">

        <div class="md-modal-header">
            <h2 id="universal-modal-title" class="headline-small">Заголовок</h2>
            <button class="icon-button modal-close-btn" onclick="closeUniversalModal()" aria-label="Закрыть">
                <span class="material-symbols-rounded">close</span>
            </button>
        </div>

        <div id="universal-modal-content" class="content-scroll">
            </div>

    </div>
</div>