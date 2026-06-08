document.querySelectorAll('.nav-link').forEach(button => {
    button.addEventListener('click', function(e) {
        e.preventDefault();

        // 1. Убираем класс active у всех ссылок в меню
        document.querySelectorAll('.nav-link').forEach(link => link.classList.remove('active'));

        // 2. Добавляем active текущей нажатой ссылке
        this.classList.add('active');

        // 3. Прячем все вкладки с контентом
        document.querySelectorAll('.tab-content').forEach(content => content.classList.add('noshow'));

        // 4. Находим нужную вкладку по ID и показываем её
        const targetId = this.id.replace('tab-', 'content-');
        const targetContent = document.getElementById(targetId);
        if (targetContent) {
            targetContent.classList.remove('noshow');
        }
    });
});