(() => {
    // Селекторы корневых элементов загрузки и UI
    const dropArea = document.getElementById('skills-drop-area');
    const fileInput = document.getElementById('skills-file-input');
    const fileNameDisplay = document.getElementById('skills-file-name-display');
    const submitBtn = document.getElementById('skills-submit-btn');
    const helpBtn = document.getElementById('skills-help-btn');
    const tooltip = document.getElementById('skills-tooltip');

    const uploadView = document.getElementById('skills-upload-view');
    const loadingView = document.getElementById('skills-loading-view');
    const resultView = document.getElementById('skills-result-view');

    let globalResultData = null; // Локальный слепок БД ответа сервера
    let sortDirections = {};

    // =====================================================================
    // 1. ИНИЦИАЛИЗАЦИЯ СТАТИСТИКИ С ФЛАСКА (Глобальный счетчик)
    // =====================================================================
    async function fetchStats() {
        try {
            const response = await fetch('http://127.0.0.1:8000/');
            if (response.ok) {
                const text = await response.text();
                // Парсим значения счетчиков из структуры шаблона Flask
                const visits = text.match(/Сервисом воспользовались[\s\S]*?<strong.*?>(\d+)<\/strong>/);
                const uploads = text.match(/Проанализировано отчетов[\s\S]*?<strong.*?>(\d+)<\/strong>/);

                document.getElementById('stat-visits-count').innerText = visits ? visits[1] : '0';
                document.getElementById('stat-uploads-count').innerText = uploads ? uploads[1] : '0';
            }
        } catch (e) {
            document.getElementById('stat-visits-count').innerText = 'н/д';
            document.getElementById('stat-uploads-count').innerText = 'н/д';
        }
    }
    fetchStats();

    // Переключатель всплывающего хелпера
    helpBtn.addEventListener('click', (e) => {
        e.stopPropagation();
        tooltip.classList.toggle('show');
    });
    document.addEventListener('click', () => tooltip.classList.remove('show'));

    // =====================================================================
    // 2. РЕАЛИЗАЦИЯ DRAG & DROP
    // =====================================================================
    ['dragenter', 'dragover'].forEach(eventName => {
        dropArea.addEventListener(eventName, (e) => {
            e.preventDefault();
            dropArea.classList.add('highlight');
        }, false);
    });

    ['dragleave', 'drop'].forEach(eventName => {
        dropArea.addEventListener(eventName, (e) => {
            e.preventDefault();
            dropArea.classList.remove('highlight');
        }, false);
    });

    dropArea.addEventListener('drop', (e) => {
        const dt = e.dataTransfer;
        const files = dt.files;
        if (files.length) {
            fileInput.files = files;
            handleFileSelection(files[0]);
        }
    });

    fileInput.addEventListener('change', () => {
        if (fileInput.files[0]) handleFileSelection(fileInput.files[0]);
    });

    function handleFileSelection(file) {
        fileNameDisplay.innerText = `Файл подготовлен: ${file.name}`;
        fileNameDisplay.style.display = 'block';
        submitBtn.disabled = false;
    }

    // =====================================================================
    // 3. ОТПРАВКА И СИМУЛЯЦИЯ СЛОЖНОГО ПРОГРЕССА
    // =====================================================================
    submitBtn.addEventListener('click', async () => {
        const file = fileInput.files[0];
        if (!file) return;

        uploadView.style.display = 'none';
        loadingView.style.display = 'flex';

        const bar = document.getElementById('skills-progress-bar');
        const msg = document.getElementById('skills-progress-msg');
        const msgs = ['Читаем файл…', 'Анализируем связи…', 'Считаем учителей…', 'Строим отчёт…', 'Почти готово…'];

        let pct = 0;
        const interval = setInterval(() => {
            pct += Math.random() * 8 + 2;
            if (pct > 92) pct = 92;
            bar.style.width = Math.round(pct) + '%';
            let mi = Math.min(Math.floor(pct / 20), msgs.length - 1);
            msg.textContent = msgs[mi];
        }, 400);

        const formData = new FormData();
        formData.append('csv_file', file);

        try {
            const response = await fetch('http://127.0.0.1:5000/analyze', {
                method: 'POST',
                body: formData
            });

            if (!response.ok) throw new Error('Ошибка бэкенда');

            const rawHtml = await response.text();

            // Вытаскиваем структуры данных, зашитые во Flask шаблоне
            const studentsMatch = rawHtml.match(/const studentsFullList = (\[[\s\S]*?\]);/);
            const teachersMatch = rawHtml.match(/const teacherModalData = (\{[\s\S]*?\});/);

            if (studentsMatch && teachersMatch) {
                // Избавляемся от возможных трейлинг-запятых Jinja, ломающих JSON.parse
                const cleanStudentsStr = studentsMatch[1].replace(/,\s*\]/g, ']').replace(/,\s*\}/g, '}');
                const cleanTeachersStr = teachersMatch[1].replace(/,\s*\}/g, '}');

                const parsedStudents = JSON.parse(cleanStudentsStr);
                const parsedTeachers = JSON.parse(cleanTeachersStr);

                globalResultData = buildDataStructure(parsedStudents, parsedTeachers);

                clearInterval(interval);
                bar.style.width = '100%';

                setTimeout(() => {
                    loadingView.style.display = 'none';
                    resultView.style.display = 'block';
                    renderInterface();
                }, 500);
            } else {
                throw new Error('Не удалось спарсить структуры данных.');
            }

        } catch (err) {
            clearInterval(interval);
            alert('Ошибка разбора данных: ' + err.message);
            window.resetSkillsAnalyzer();
        }
    });

    function buildDataStructure(students, teachersData) {
        let problemCount = 0;
        let classesSet = new Set();
        let teachersSet = new Set(Object.keys(teachersData));

        students.forEach(s => {
            classesSet.add(s.cls);
            if (s.missingCount > 0) problemCount++;
        });

        return {
            students: students,
            teachersData: teachersData,
            totalStudents: students.length,
            totalTeachers: teachersSet.size,
            totalClasses: classesSet.size,
            totalProblems: problemCount,
            classesList: Array.from(classesSet).sort((a,b) => a.localeCompare(b, undefined, {numeric:true}))
        };
    }

    // =====================================================================
    // 4. ОТРЕНДЕР ИНТЕРФЕЙСА РЕЗУЛЬТАТОВ (Генерация таблиц)
    // =====================================================================
    function renderInterface() {
        document.getElementById('res-total-students').innerText = globalResultData.totalStudents;
        document.getElementById('res-total-teachers').innerText = globalResultData.totalTeachers;
        document.getElementById('res-total-classes').innerText = globalResultData.totalClasses;
        document.getElementById('res-total-problems').innerText = globalResultData.totalProblems;

        // 1. Ученики
        const studentsBody = document.querySelector('#skills-t-students tbody');
        studentsBody.innerHTML = globalResultData.students.map(s => `
            <tr>
                <td><span class="skills-badge badge-blue">${s.cls}</span></td>
                <td class="fw-bold">${s.student}</td>
                <td><span class="skills-text-muted">Связей: ${s.count} из ${s.max}</span></td>
            </tr>
        `).join('');

        // 2. Учителя
        const teachersBody = document.querySelector('#skills-t-teachers tbody');
        teachersBody.innerHTML = Object.keys(globalResultData.teachersData).map(t => {
            const loadInfo = globalResultData.teachersData[t].map(c => `
                <span class="skills-badge badge-blue" style="margin-right:4px; margin-bottom:4px;">
                    ${c.class}: ${c.count} чел.
                </span>
            `).join('');
            return `
                <tr>
                    <td class="fw-bold skills-clickable-row" data-teacher="${t}">${t}</td>
                    <td><div class="skills-flex-list">${loadInfo}</div></td>
                </tr>
            `;
        }).join('');

        // Клики по учителям
        teachersBody.querySelectorAll('.skills-clickable-row').forEach(td => {
            td.addEventListener('click', () => openSkillsTeacherModal(td.getAttribute('data-teacher')));
        });

        // 3. Классы
        const classesBody = document.querySelector('#skills-t-classes tbody');
        classesBody.innerHTML = globalResultData.classesList.map(c => {
            const countInClass = globalResultData.students.filter(s => s.cls === c).length;
            return `
                <tr>
                    <td><span class="skills-badge badge-blue">${c}</span></td>
                    <td><span class="skills-badge badge-green">${countInClass} учеников</span></td>
                    <td><span class="skills-text-muted">Класс верифицирован</span></td>
                </tr>
            `;
        }).join('');

        // Селект графиков
        const select = document.getElementById('skills-class-select');
        select.innerHTML = globalResultData.classesList.map(c => `<option value="${c}">${c}</option>`).join('');

        // 4. Критические аномалии
        const problemsBody = document.querySelector('#skills-t-problems tbody');
        const problematicStudents = globalResultData.students.filter(s => s.missingCount > 0);
        if (problematicStudents.length === 0) {
            problemsBody.innerHTML = `<tr><td colspan="4" style="text-align:center; color:var(--md-sys-color-outline)">Аномалий не обнаружено. Все нагрузки распределены корректно!</td></tr>`;
        } else {
            problemsBody.innerHTML = problematicStudents.map(s => `
                <tr class="skills-danger-row">
                    <td><span class="skills-badge badge-red">${s.cls}</span></td>
                    <td class="fw-bold">${s.student}</td>
                    <td class="skills-text-muted">Привязок: ${s.count}/${s.max}</td>
                    <td class="fw-bold text-error">Пропуск ${s.missingCount} подгрупп(ы)</td>
                </tr>
            `).join('');
        }
    }

    // =====================================================================
    // 5. ПОДСИСТЕМА УПРАВЛЕНИЯ ТАБАМИ, ПОИСКОМ, СОРТИРОВКОЙ И ЭКСПОРТОМ
    // =====================================================================
    window.switchSkillsTab = (tabId, button) => {
        document.querySelectorAll('.skills-tab-section').forEach(s => s.classList.remove('active'));
        document.querySelectorAll('.skills-inner-tab').forEach(t => t.classList.remove('active'));
        document.getElementById('skills-sect-' + tabId).classList.add('active');
        button.classList.add('active');
        if (tabId === 'chart') {
            renderSkillsMatrixChart(document.getElementById('skills-class-select').value);
        }
    };

    window.renderSkillsMatrixChart = (litera) => {
        const container = document.getElementById('skills-matrix-bars-container');
        container.innerHTML = '';
        const filtered = globalResultData.students.filter(s => s.cls === litera).sort((a,b) => a.student.localeCompare(b.student));

        filtered.forEach(s => {
            const activePct = (s.count / s.max) * 100;
            const missingPct = 100 - activePct;
            const row = document.createElement('div');
            row.className = 'skills-bar-row';
            row.innerHTML = `
                <div class="skills-bar-name" title="${s.student}">${s.student}</div>
                <div class="skills-bar-track">
                    <div class="bar-green-fill" style="width: ${activePct}%"></div>
                    <div class="bar-red-fill" style="width: ${missingPct}%"></div>
                </div>
                <div class="skills-bar-total">${s.count}/${s.max}</div>
            `;
            container.appendChild(row);
        });
    };

    window.filterSkillsTable = (tableId, query) => {
        const q = query.toLowerCase().trim();
        document.querySelectorAll(`#${tableId} tbody tr`).forEach(row => {
            row.style.display = row.textContent.toLowerCase().includes(q) ? '' : 'none';
        });
    };

    window.sortSkillsTable = (tableId, colIdx, header) => {
        const tbody = document.getElementById(tableId).querySelector('tbody');
        const rows = Array.from(tbody.querySelectorAll('tr'));
        if(!rows.length) return;

        header.parentNode.querySelectorAll('th').forEach(th => { if(th !== header) th.className = ''; });
        const dir = sortDirections[tableId + colIdx] === 'asc' ? 'desc' : 'asc';
        sortDirections[tableId + colIdx] = dir;
        header.className = dir;

        rows.sort((a, b) => {
            const valA = a.cells[colIdx].textContent.trim();
            const valB = b.cells[colIdx].textContent.trim();
            return dir === 'asc'
                ? valA.localeCompare(valB, undefined, {numeric: true, sensitivity: 'base'})
                : valB.localeCompare(valA, undefined, {numeric: true, sensitivity: 'base'});
        });
        rows.forEach(row => tbody.appendChild(row));
    };

    window.openSkillsTeacherModal = (teacherName) => {
        document.getElementById('skills-m-teacher-name').textContent = teacherName;
        const body = document.getElementById('skills-m-teacher-students');
        body.innerHTML = (globalResultData.teachersData[teacherName] || []).map((c, idx) => `
            <div class="skills-modal-list-item">
                <span class="item-index">${idx + 1}</span>
                <span class="skills-badge badge-blue">${c.class}</span>
                <span>Нагрузка в классе: <strong>${c.count} чел.</strong></span>
            </div>
        `).join('');
        document.getElementById('skills-teacher-modal').style.display = 'flex';
    };

    window.closeSkillsTeacherModal = () => {
        document.getElementById('skills-teacher-modal').style.display = 'none';
    };

    window.filterSkillsModalList = (query) => {
        const q = query.toLowerCase().trim();
        document.querySelectorAll('#skills-m-teacher-students .skills-modal-list-item').forEach(item => {
            item.style.display = item.textContent.toLowerCase().includes(q) ? '' : 'none';
        });
    };

    window.exportSkillsCSV = (tableId, filename) => {
        let csv = [];
        document.querySelectorAll(`#${tableId} tr`).forEach(row => {
            if (row.style.display === 'none') return;
            let rowData = [];
            row.querySelectorAll('th, td').forEach(cell => {
                let text = cell.textContent.replace(/\s+/g, ' ').trim().replace(/"/g, '""');
                rowData.push('"' + text + '"');
            });
            csv.push(rowData.join(';'));
        });
        const blob = new Blob(['\uFEFF' + csv.join('\n')], { type: 'text/csv;charset=utf-8;' });
        const link = document.createElement('a');
        link.href = URL.createObjectURL(blob);
        link.setAttribute('download', `${filename}_${new Date().toISOString().slice(0,10)}.csv`);
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    };

    window.resetSkillsAnalyzer = () => {
        resultView.style.display = 'none';
        loadingView.style.display = 'none';
        uploadView.style.display = 'block';
        fileInput.value = '';
        fileNameDisplay.innerText = '';
        fileNameDisplay.style.display = 'none';
        submitBtn.disabled = true;
        globalResultData = null;
        fetchStats();
    };
})();