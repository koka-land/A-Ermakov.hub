document.querySelectorAll('.nav-link').forEach(button => {
    button.addEventListener('click', function(e) {
        e.preventDefault();

        // 1. Подсвечиваем активную кнопку
        document.querySelectorAll('.nav-link').forEach(link => link.classList.remove('active'));
        this.addClass = this.classList.add('active');

        const targetId = this.id.replace('tab-', 'content-');
        const targetContent = document.getElementById(targetId);

        if (targetContent) {
            if (!targetContent.classList.contains('noshow')) return;

            // 2. Гасим и прячем все старые вкладки
            document.querySelectorAll('.tab-content').forEach(content => {
                content.classList.add('noshow');
                content.classList.remove('fade-in');
            });

            // 3. Включаем целевую вкладку, но делаем её пока невидимой (fade-in)
            targetContent.classList.remove('noshow');
            targetContent.classList.add('fade-in');

            // 4. Магия: два кадра анимации, чтобы браузер успел понять изменения
            requestAnimationFrame(() => {
                requestAnimationFrame(() => {
                    targetContent.classList.remove('fade-in');
                });
            });
        }
    });
});