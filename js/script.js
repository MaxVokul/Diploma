document.addEventListener('DOMContentLoaded', function() {
    // Получаем все необходимые элементы
    const toggleButtons = document.querySelectorAll('.toggle-btn');
    const loginForm = document.querySelector('.login-form');
    const registerForm = document.querySelector('.register-form');
    const modalWindow = document.querySelector('.modal-window');
    const overlay = document.querySelector('.overlay');
    const closeModalBtn = document.querySelector('.btn--close-modal-window');
    const showModalBtns = document.querySelectorAll('.btn--show-modal-window');

    // Функция переключения форм
    function switchForm(tabName) {
        // Убираем активный класс со всех кнопок
        toggleButtons.forEach(btn => btn.classList.remove('active'));

        // Скрываем обе формы
        if (loginForm) loginForm.style.display = 'none';
        if (registerForm) registerForm.style.display = 'none';

        // Показываем нужную форму и делаем кнопку активной
        if (tabName === 'login') {
            const loginBtn = document.querySelector('[data-tab="login"]');
            if (loginBtn) loginBtn.classList.add('active');
            if (loginForm) loginForm.style.display = 'flex'; // Используем flex для совместимости
        } else if (tabName === 'register') {
            const registerBtn = document.querySelector('[data-tab="register"]');
            if (registerBtn) registerBtn.classList.add('active');
            if (registerForm) registerForm.style.display = 'flex'; // Используем flex
        }
    }

    // Обработчик клика по табам
    if (toggleButtons) {
        toggleButtons.forEach(btn => {
            btn.addEventListener('click', function() {
                const tab = this.getAttribute('data-tab');
                if (tab) switchForm(tab);
            });
        });
    }

    // Открытие модального окна
    function openModal() {
        if (modalWindow) modalWindow.classList.remove('hidden');
        if (overlay) overlay.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
        switchForm('login'); // По умолчанию показываем логин
    }

    // Закрытие модального окна
    function closeModal() {
        if (modalWindow) modalWindow.classList.add('hidden');
        if (overlay) overlay.classList.add('hidden');
        document.body.style.overflow = '';
    }

    // Назначаем события на кнопки открытия
    if (showModalBtns) {
        showModalBtns.forEach(btn => {
            btn.addEventListener('click', openModal);
        });
    }

    // Назначаем событие на кнопку закрытия
    if (closeModalBtn) {
        closeModalBtn.addEventListener('click', closeModal);
    }

    // Закрытие по клику на оверлей
    if (overlay) {
        overlay.addEventListener('click', closeModal);
    }

    // Закрытие по ESC
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && !modalWindow.classList.contains('hidden')) {
            closeModal();
        }
    });

    // Предотвращаем отправку форм (для демо)
    document.querySelectorAll('.modal__form').forEach(form => {
        if (form) {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                alert('Форма отправлена! В реальном проекте здесь была бы отправка на сервер.');
                closeModal();
            });
        }
    });

    // Инициализация: при загрузке страницы — показать логин
    switchForm('login');
});