document.addEventListener('DOMContentLoaded', function() {
    // Получаем все необходимые элементы
    const toggleButtons = document.querySelectorAll('.toggle-btn');
    const loginForm = document.querySelector('.login-form');
    const registerForm = document.querySelector('.register-form');
    const modalWindow = document.querySelector('.modal-window');
    const overlay = document.querySelector('.overlay');
    const closeModalBtn = document.querySelector('.btn--close-modal-window');


    // Функция переключения форм
    function switchForm(tabName) {
        toggleButtons.forEach(btn => btn.classList.remove('active'));
        if (loginForm) loginForm.style.display = 'none';
        if (registerForm) registerForm.style.display = 'none';

        if (tabName === 'login') {
            const loginBtn = document.querySelector('[data-tab="login"]');
            if (loginBtn) loginBtn.classList.add('active');
            if (loginForm) loginForm.style.display = 'flex';
        } else if (tabName === 'register') {
            const registerBtn = document.querySelector('[data-tab="register"]');
            if (registerBtn) registerBtn.classList.add('active');
            if (registerForm) registerForm.style.display = 'flex';
        }
    }


    function openModal() {
        if (modalWindow) modalWindow.classList.remove('hidden');
        if (overlay) overlay.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
        switchForm('login');
    }

    // Закрытие модального окна
    function closeModal() {
        if (modalWindow) modalWindow.classList.add('hidden');
        if (overlay) overlay.classList.add('hidden');
        document.body.style.overflow = '';
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

    // НАЗНАЧАЕМ СОБЫТИЕ ТОЛЬКО НА ИКОНКУ ПРОФИЛЯ
    const profileLink = document.querySelector('.btn--show-modal-window.profile-link');
    // Новый индикатор: есть ли пользователь в системе?
    const isAuthenticated = document.getElementById('user-authenticated') !== null;

    if (profileLink) {
        profileLink.addEventListener('click', function(e) {
            e.preventDefault();
            // Проверяем: залогинен ли пользователь?
            if (isAuthenticated) {
                // Если да — переходим на профиль
                window.location.href = '/profile.php';
            } else {
                // Если нет — открываем модалку
                openModal();
            }
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



    // Инициализация: при загрузке страницы — показать логин
    switchForm('login');
});

// Profile Page Functionality
function initProfilePage() {
// Обработчик для кнопки удаления аккаунта
    const deleteBtn = document.querySelector('.btn-delete');
    if (deleteBtn) {
        deleteBtn.addEventListener('click', function(e) {
            e.preventDefault();
            if (confirm('Are you sure you want to delete your account? This action cannot be undone.')) {
                alert('Account deleted successfully');
                window.location.href = '/index.php';
            }
        });
    }
    // Обработчики для кнопок настроек (ТОЛЬКО для ссылок)
    const settingLinkButtons = document.querySelectorAll('a.btn-secondary');
    settingLinkButtons.forEach(link => {
        link.addEventListener('click', function(e) {
            // Оставляем поведение форм неперехваченным
            e.preventDefault();
            const action = this.textContent.trim();
            alert(`${action} feature will be implemented soon!`);
        });
    });
}

// Инициализация функционала профиля при загрузке страницы
document.addEventListener('DOMContentLoaded', function() {
    if (document.querySelector('.profile-container')) {
        initProfilePage();
    }
});