<div class="program-form-container" id="study-skills-root">

    <div id="skills-upload-view">
        <div class="skills-upload-header">
            <p class="body-large text-secondary">Загрузите CSV-файл с данными об учениках для автоматического поиска аномалий в распределении нагрузки.</p>

            <div class="skills-help-wrapper">
                <button class="icon-button help-trigger-btn" id="skills-help-btn" aria-label="Инструкция">
                    <span class="material-symbols-rounded">help</span>
                </button>
                <div class="skills-tooltip" id="skills-tooltip">
                    <h5 class="title-small"><span class="material-symbols-rounded">info</span> Как получить CSV-файл?</h5>
                    <ol class="body-small">
                        <li>Войдите на портал отчётов <a href="https://mes-reports.mos.ru" target="_blank">mes-reports.mos.ru</a></li>
                        <li>В левом меню откройте раздел <strong>«Контингент»</strong></li>
                        <li>Выберите отчёт <strong>«[Click] Оценка учебных умений»</strong></li>
                        <li>Выгрузите данные в формате <strong>.CSV</strong>, дождитесь формирования и распакуйте ZIP-архив.</li>
                    </ol>
                </div>
            </div>
        </div>

        <div class="skills-drop-zone" id="skills-drop-area">
            <input type="file" accept=".csv" id="skills-file-input">
            <span class="material-symbols-rounded upload-icon">cloud_upload</span>
            <span class="title-medium upload-text">Выберите файл или перетащите его сюда</span>
            <span class="label-small upload-hint">Допустимый формат: CSV</span>
            <div class="skills-file-name" id="skills-file-name-display"></div>
        </div>

        <button id="skills-submit-btn" class="ripple-target program-action-btn" disabled style="margin-top: 16px; width: 100%; justify-content: center;">
            <span class="material-symbols-rounded">analytics</span> Анализировать данные
        </button>

        <div class="skills-stats-row">
            <div class="skills-stat-card">
                <span class="material-symbols-rounded">visibility</span>
                <span class="label-small stat-title">Визитов платформы</span>
                <strong id="stat-visits-count">...</strong>
            </div>
            <div class="skills-stat-card">
                <span class="material-symbols-rounded">cloud_done</span>
                <span class="label-small stat-title">Обработано отчетов</span>
                <strong id="stat-uploads-count">...</strong>
            </div>
        </div>
    </div>

    <div id="skills-loading-view" style="display: none;">
        <div class="skills-loader-wrapper">
            <span class="material-symbols-rounded loading-spinner">autorenew</span>
            <h3 class="title-large">Анализируем данные</h3>
            <div class="skills-progress-track">
                <div class="skills-progress-fill" id="skills-progress-bar"></div>
            </div>
            <p class="body-medium text-secondary" id="skills-progress-msg">Читаем файл…</p>
        </div>
    </div>

    <div id="skills-result-view" style="display: none;">
        <button class="skills-back-btn" onclick="resetSkillsAnalyzer()">
            <span class="material-symbols-rounded">arrow_back</span> Вернуться к загрузке
        </button>

        <div class="skills-summary-grid">
            <div class="summary-card"><span class="label-small">Учеников</span><strong id="res-total-students">-</strong></div>
            <div class="summary-card"><span class="label-small">Учителей</span><strong id="res-total-teachers">-</strong></div>
            <div class="summary-card"><span class="label-small">Классов</span><strong id="res-total-classes">-</strong></div>
            <div class="summary-card card-danger"><span class="label-small">Проблемные</span><strong id="res-total-problems">-</strong></div>
        </div>

        <div class="skills-tabs-row">
            <button class="skills-inner-tab active" onclick="switchSkillsTab('students', this)">
                <span class="material-symbols-rounded">group</span> Ученики
            </button>
            <button class="skills-inner-tab" onclick="switchSkillsTab('teachers', this)">
                <span class="material-symbols-rounded">person</span> Учителя
            </button>
            <button class="skills-inner-tab" onclick="switchSkillsTab('classes', this)">
                <span class="material-symbols-rounded">school</span> Классы
            </button>
            <button class="skills-inner-tab" onclick="switchSkillsTab('chart', this)">
                <span class="material-symbols-rounded">bar_chart</span> График
            </button>
            <button class="skills-inner-tab item-danger" onclick="switchSkillsTab('problems', this)">
                <span class="material-symbols-rounded">warning</span> Проблемные
            </button>
        </div>

        <div class="skills-tab-section active" id="skills-sect-students">
            <div class="skills-table-toolbar">
                <input type="text" class="program-input" placeholder="Поиск ученика или класса…" oninput="filterSkillsTable('skills-t-students', this.value)">
                <button class="btn-export-csv" onclick="exportSkillsCSV('skills-t-students','ученики')">⬇ CSV</button>
            </div>
            <table id="skills-t-students" class="skills-data-table">
                <thead>
                    <tr>
                        <th onclick="sortSkillsTable('skills-t-students', 0, this)">Класс <span class="sort-direction-icon"></span></th>
                        <th onclick="sortSkillsTable('skills-t-students', 1, this)">Ученик <span class="sort-direction-icon"></span></th>
                        <th>Учителя ребенка</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>

        <div class="skills-tab-section" id="skills-sect-teachers">
            <div class="skills-table-toolbar">
                <input type="text" class="program-input" placeholder="Поиск учителя…" oninput="filterSkillsTable('skills-t-teachers', this.value)">
                <button class="btn-export-csv" onclick="exportSkillsCSV('skills-t-teachers','учителя')">⬇ CSV</button>
            </div>
            <table id="skills-t-teachers" class="skills-data-table">
                <thead>
                    <tr>
                        <th onclick="sortSkillsTable('skills-t-teachers', 0, this)">Учитель <span class="sort-direction-icon"></span></th>
                        <th>Привязанная нагрузка по классам</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>

        <div class="skills-tab-section" id="skills-sect-classes">
            <div class="skills-table-toolbar">
                <input type="text" class="program-input" placeholder="Поиск класса…" oninput="filterSkillsTable('skills-t-classes', this.value)">
                <button class="btn-export-csv" onclick="exportSkillsCSV('skills-t-classes','классы')">⬇ CSV</button>
            </div>
            <table id="skills-t-classes" class="skills-data-table">
                <thead>
                    <tr>
                        <th onclick="sortSkillsTable('skills-t-classes', 0, this)">Класс <span class="sort-direction-icon"></span></th>
                        <th>Всего детей в МЭШ</th>
                        <th>Всего учителей предмета</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>

        <div class="skills-tab-section" id="skills-sect-chart">
            <div class="skills-chart-filter-block">
                <label for="skills-class-select" class="label-medium">Выберите класс для визуализации:</label>
                <select id="skills-class-select" class="program-input" style="width: auto; display: inline-block;" onchange="renderSkillsMatrixChart(this.value)"></select>
            </div>
            <div class="skills-chart-legend">
                <span><span class="legend-dot dot-green"></span>Учитель назначен</span>
                <span><span class="legend-dot dot-red"></span>Пропуск (Аномалия)</span>
            </div>
            <div id="skills-matrix-bars-container" class="skills-bars-grid"></div>
        </div>

        <div class="skills-tab-section" id="skills-sect-problems">
            <div class="skills-table-toolbar">
                <input type="text" class="program-input" placeholder="Поиск по аномалиям…" oninput="filterSkillsTable('skills-t-problems', this.value)">
                <button class="btn-export-csv" onclick="exportSkillsCSV('skills-t-problems','аномалии')">⬇ CSV</button>
            </div>
            <table id="skills-t-problems" class="skills-data-table">
                <thead>
                    <tr>
                        <th onclick="sortSkillsTable('skills-t-problems', 0, this)">Класс <span class="sort-direction-icon"></span></th>
                        <th onclick="sortSkillsTable('skills-t-problems', 1, this)">Ученик <span class="sort-direction-icon"></span></th>
                        <th>Текущие учителя</th>
                        <th class="text-error">❌ Потерянные учителя</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>

<div class="skills-inner-modal-overlay" id="skills-teacher-modal" style="display: none;">
    <div class="skills-inner-modal">
        <div class="skills-inner-modal-header">
            <h3 class="title-large" id="skills-m-teacher-name">ФИО Учителя</h3>
            <button class="icon-button" onclick="closeSkillsTeacherModal()">
                <span class="material-symbols-rounded">close</span>
            </button>
        </div>
        <p class="body-small text-secondary" style="margin-bottom: 12px;">Закрепленный список учеников по классам</p>
        <input type="text" class="program-input" placeholder="Поиск класса нагрузки…" oninput="filterSkillsModalList(this.value)">
        <div class="skills-inner-modal-body" id="skills-m-teacher-students"></div>
    </div>
</div>

<script src="progs/study_skills/ui.js"></script>