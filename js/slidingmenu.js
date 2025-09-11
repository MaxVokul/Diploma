document.addEventListener('DOMContentLoaded', function() {

    const hamburgerBtn = document.querySelector('.hamburger').closest('a');
    const slideMenu = document.querySelector('.slide-menu');
    const closeBtn = document.querySelector('.btn--close-slide-menu');
    const slideOverlay = document.querySelector('.slide-overlay');
    const body = document.body;

    function openMenu() {
        slideMenu.classList.remove('hidden');
        slideOverlay.classList.remove('hidden');
        body.classList.add('menu-open');
    }

    function closeMenu() {
        slideMenu.classList.add('hidden');
        slideOverlay.classList.add('hidden');
        body.classList.remove('menu-open');
    }

    hamburgerBtn.addEventListener('click', function(e) {
        e.preventDefault();
        openMenu();
    });

    closeBtn.addEventListener('click', closeMenu);
    slideOverlay.addEventListener('click', closeMenu);

    // Optional: Close on Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closeMenu();
    });

});