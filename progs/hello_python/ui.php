<div class="list-container" style="padding: 16px; display: flex; flex-direction: column; gap: 20px;">
    <div class="input-field-container">
        <label for="py-text-input" class="label-medium" style="color: var(--md-sys-color-on-surface-variant); margin-bottom: 8px; display: block;">
            Введите текст для анализа в Python:
        </label>
        <input type="text" id="py-text-input" placeholder="Например: привет из Альт Линукса!"
               style="width: 100%; padding: 12px 16px; border: 1px solid var(--md-sys-color-outline); border-radius: 8px; background: var(--md-sys-color-surface); color: var(--md-sys-color-on-surface); font-size: 16px;">
    </div>

    <button id="run-py-btn" class="ripple-target"
            style="align-self: flex-start; background: var(--md-sys-color-primary); color: var(--md-sys-color-on-primary); border: none; padding: 10px 24px; border-radius: 100px; font-weight: 500; cursor: pointer; display: flex; align-items: center; gap: 8px;">
        <span class="material-symbols-rounded" style="font-size: 20px;">play_arrow</span>
        Запустить Python
    </button>

    <div class="content-scroll">
    <div id="py-result-card" class="md-card elevated-card" style="display: none; background: var(--md-sys-color-surface-container); border-radius: 12px; padding: 16px; margin-top: 12px;">
        <h3 class="title-medium" style="color: var(--md-sys-color-primary); margin-bottom: 12px; display: flex; align-items: center; gap: 8px;">
            <span class="material-symbols-rounded">analytics</span> Результат обработки
        </h3>
        <div id="py-result-content" class="body-medium" style="color: var(--md-sys-color-on-surface); display: flex; flex-direction: column; gap: 8px;">
            </div>
    </div></div>
</div>

<script src="progs/hello_python/ui.js"></script>