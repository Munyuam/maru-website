<?php
use App\Helpers\Session;

$isLoggedIn = Session::isLoggedIn();
$userRole = Session::getUserRole();
$currentPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Normalize base path for active link checking
$scriptName = $_SERVER['SCRIPT_NAME'] ?? '';
$basePath = dirname($scriptName);
$basePath = ($basePath === DIRECTORY_SEPARATOR || $basePath === '.') ? '' : str_replace('\\', '/', $basePath);
if ($basePath !== '' && strpos($currentPath, $basePath) === 0) {
    $currentPath = substr($currentPath, strlen($basePath));
}
if (empty($currentPath)) {
    $currentPath = '/';
}
?>
<header class="navbar">
    <div class="container">
        <a href="<?= url('/') ?>" class="navbar-brand">
            <img src="<?= url('/public/assets/logo.png') ?>" alt="MARU Logo" class="navbar-logo">
            MARU
        </a>
        
        <button class="nav-toggle" id="mobile-menu-btn">
            <i class="ph ph-list"></i>
        </button>
        
        <ul class="navbar-nav" id="main-nav">
                <?php if ($isLoggedIn): ?>
                    <?php if ($userRole === 'admin'): ?>
                        <li><a href="<?= url('/admin') ?>" class="navbar-link <?= $currentPath === '/admin' ? 'active' : '' ?>">Dashboard</a></li>
                    <?php elseif ($userRole === 'player'): ?>
                        <li><a href="<?= url('/player/profile') ?>" class="navbar-link <?= strpos($currentPath, '/player/profile') === 0 ? 'active' : '' ?>"><i class="ph ph-user-circle mr-1"></i> My Profile</a></li>
                        <li><a href="<?= url('/player/status') ?>" class="navbar-link <?= $currentPath === '/player/status' ? 'active' : '' ?>"><i class="ph ph-identification-badge mr-1"></i> Status</a></li>
                    <?php elseif ($userRole === 'coach'): ?>
                        <li><a href="<?= url('/coach/profile') ?>" class="navbar-link <?= strpos($currentPath, '/coach/profile') === 0 ? 'active' : '' ?>"><i class="ph ph-user-circle mr-1"></i> Profile</a></li>
                        <li><a href="<?= url('/coach/team') ?>" class="navbar-link <?= $currentPath === '/coach/team' ? 'active' : '' ?>"><i class="ph ph-users-three mr-1"></i> My Team</a></li>
                    <?php endif; ?>
                    
                    <li>
                        <form action="<?= url('/logout') ?>" method="POST" class="form-inline">
                            <input type="hidden" name="csrf_token" value="<?= Session::generateCsrfToken() ?>">
                            <button type="submit" class="btn btn-ghost btn-sm">Logout</button>
                        </form>
                    </li>
                <?php else: ?>
                    <li><a href="<?= url('/login') ?>" class="btn btn-outline">Login</a></li>
                    <li><a href="<?= url('/register') ?>" class="btn btn-primary">Register</a></li>
                <?php endif; ?>
                <li>
                    <button id="theme-toggle" class="btn btn-ghost btn-icon text-xl" title="Toggle Theme">
                        <i class="ph ph-moon dark-icon hidden"></i>
                        <i class="ph ph-sun light-icon hidden"></i>
                    </button>
                </li>
            </ul>
    </div>
</header>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const themeBtn = document.getElementById('theme-toggle');
        const moonIcon = themeBtn.querySelector('.ph-moon');
        const sunIcon = themeBtn.querySelector('.ph-sun');
        const mobileMenuBtn = document.getElementById('mobile-menu-btn');
        const mainNav = document.getElementById('main-nav');

        function updateIcons(theme) {
            if (theme === 'dark') {
                moonIcon.classList.add('hidden');
                sunIcon.classList.remove('hidden');
            } else {
                sunIcon.classList.add('hidden');
                moonIcon.classList.remove('hidden');
            }
        }

        const currentTheme = document.documentElement.getAttribute('data-theme');
        updateIcons(currentTheme);

        themeBtn.addEventListener('click', () => {
            const current = document.documentElement.getAttribute('data-theme');
            const newTheme = current === 'dark' ? 'light' : 'dark';
            document.documentElement.setAttribute('data-theme', newTheme);
            localStorage.setItem('theme', newTheme);
            updateIcons(newTheme);
        });

        if (mobileMenuBtn) {
            mobileMenuBtn.addEventListener('click', () => {
                mainNav.classList.toggle('show');
            });
        }
    });
</script>
