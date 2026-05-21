document.addEventListener('DOMContentLoaded', function() {
    // Mobile menu toggle
    var menuBtn = document.getElementById('mobile-menu-btn');
    var mainNav = document.getElementById('main-nav');
    if (menuBtn && mainNav) {
        menuBtn.addEventListener('click', function() {
            mainNav.classList.toggle('show');
        });
    }
});
