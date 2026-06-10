(() => {
    const runBtn = document.getElementById('run-py-btn');
    const textInput = document.getElementById('py-text-input');
    const resultCard = document.getElementById('py-result-card');
    const resultContent = document.getElementById('py-result-content');

    if (!runBtn) return;

    runBtn.addEventListener('click', async () => {
        const textValue = textInput.value.trim();
        if (!textValue) {
            alert('Пожалуйста, введите текст');
            return;
        }

        runBtn.innerHTML = `<span class="material-symbols-rounded spinning">autorenew</span> Считаем...`;
        runBtn.style.opacity = '0.7';

        try {
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
                resultContent.innerHTML = `
                    <p><strong>Оригинал:</strong> ${result.data.original}</p>
                    <p><strong>В верхнем регистре:</strong> <span style="color: var(--md-sys-color-secondary); font-weight: bold;">${result.data.uppercase}</span></p>
                    <hr style="border: 0; border-top: 1px solid var(--md-sys-color-outline-variant); margin: 8px 0;">
                    <p><strong>Всего символов:</strong> ${result.data.stats.chars}</p>
                    <p><strong>Количество слов:</strong> ${result.data.stats.words}</p>
                    <p><strong>Количество единиц (1):</strong> <span style="color: var(--md-sys-color-primary); font-weight: bold;">${result.data.stats.one}</span></p>
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
            runBtn.innerHTML = `<span class="material-symbols-rounded">play_arrow</span> Запустить Python`;
            runBtn.style.opacity = '1';
        }
    });
})();