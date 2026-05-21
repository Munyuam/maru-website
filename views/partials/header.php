<?php
use App\Helpers\Session;

$isLoggedIn = Session::isLoggedIn();
$userRole = Session::getUserRole();
$currentPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
?>
<header class="navbar">
    <div class="container">
        <a href="/" class="navbar-brand">
            <i class="ph-fill ph-rugby text-2xl text-primary"></i> MARU
        </a>
        
        <button class="nav-toggle" id="mobile-menu-btn">
            <i class="ph ph-list"></i>
        </button>
        
        <nav class="navbar-nav" id="main-nav">
                <?php if ($isLoggedIn): ?>
                    <?php if ($userRole === 'admin'): ?>
                        <li><a href="/admin" class="navbar-link <?= $currentPath === '/admin' ? 'active' : '' ?>">Dashboard</a></li>
                    <?php elseif ($userRole === 'player'): ?>
                        <li><a href="/player/profile" class="navbar-link <?= strpos($currentPath, '/player/profile') === 0 ? 'active' : '' ?>">My Profile</a></li>
                        <li><a href="/player/status" class="navbar-link <?= $currentPath === '/player/status' ? 'active' : '' ?>">Status</a></li>
                    <?php elseif ($userRole === 'coach'): ?>
                        <li><a href="/coach/profile" class="navbar-link <?= strpos($currentPath, '/coach/profile') === 0 ? 'active' : '' ?>">Profile</a></li>
                        <li><a href="/coach/team" class="navbar-link <?= $currentPath === '/coach/team' ? 'active' : '' ?>">My Team</a></li>
                    <?php endif; ?>
                    
                    <li>
                        <form action="/logout" method="POST" style="display:inline;">
                            <input type="hidden" name="csrf_token" value="<?= Session::generateCsrfToken() ?>">
                            <button type="submit" class="btn btn-ghost btn-sm">Logout</button>
                        </form>
                    </li>
                <?php else: ?>
                    <li><a href="/login" class="btn btn-outline">Login</a></li>
                    <li><a href="/register" class="btn btn-primary">Register</a></li>
                <?php endif; ?>
                <li>
                    <button id="theme-toggle" class="btn btn-ghost btn-icon text-xl" title="Toggle Theme">
                        <i class="ph ph-moon dark-icon hidden"></i>
                        <i class="ph ph-sun light-icon hidden"></i>
                    </button>
                </li>
            </ul>
        </nav>
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
