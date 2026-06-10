<div class="program-form-container">

    <div class="input-field-container">
        <label for="py-text-input" class="label-medium program-label">
            Введите текст для анализа в Python:
        </label>
        <input type="text" id="py-text-input" class="program-input" placeholder="Например: привет из Альт Линукса!">
    </div>

    <button id="run-py-btn" class="ripple-target program-action-btn">
        <span class="material-symbols-rounded">play_arrow</span>
        Запустить Python
    </button>

    <div id="py-result-card" class="md-card elevated-card program-result-card">
        <h3 class="title-medium">
            <span class="material-symbols-rounded">analytics</span> Результат обработки
        </h3>
        <div id="py-result-content" class="body-medium">
            </div>
    </div>

</div>

<script src="progs/hello_python/ui.js"></script>