<?php
use App\Helpers\Session;

$currentPath = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?? '';
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

$adminUser = Session::getUser();

function isActive($path, $prefix = false): string {
    global $currentPath;
    $currentPath = $currentPath ?? '';
    if ($prefix) {
        return strpos($currentPath, $path) === 0 ? 'active' : '';
    }
    return $currentPath === $path ? 'active' : '';
}
?>
<aside class="dashboard-sidebar">
    <div class="sidebar-brand">
        <a href="<?= url('/') ?>" class="navbar-brand">
            <img src="<?= url('/public/assets/logo.png') ?>" alt="MARU Logo" class="sidebar-logo" style="width: 40px; height: 40px; object-fit: contain;">
            <span class="sidebar-brand-text">MARU Admin</span>
        </a>
    </div>
    
    <nav class="sidebar-nav">
        <a href="<?= url('/') ?>" class="sidebar-link <?= isActive('/', true) && $currentPath === '/' ?>">
            <i class="ph ph-house sidebar-link-icon"></i>
            <span>View Site</span>
        </a>
        <a href="<?= url('/admin') ?>" class="sidebar-link <?= isActive('/admin') ?>">
            <i class="ph ph-chart-bar sidebar-link-icon"></i>
            <span>Dashboard</span>
        </a>
        <a href="<?= url('/admin/players') ?>" class="sidebar-link <?= isActive('/admin/players', true) ?>">
            <i class="ph ph-users-three sidebar-link-icon"></i>
            <span>Players</span>
        </a>
        <a href="<?= url('/admin/teams') ?>" class="sidebar-link <?= isActive('/admin/teams', true) ?>">
            <i class="ph ph-trophy sidebar-link-icon"></i>
            <span>Teams</span>
        </a>
        <a href="<?= url('/admin/coaches') ?>" class="sidebar-link <?= isActive('/admin/coaches', true) ?>">
            <i class="ph ph-chalkboard-teacher sidebar-link-icon"></i>
            <span>Coaches</span>
        </a>
        <a href="<?= url('/admin/documents') ?>" class="sidebar-link <?= isActive('/admin/documents', true) ?>">
            <i class="ph ph-file-text sidebar-link-icon"></i>
            <span>Documents</span>
        </a>
        <a href="<?= url('/admin/announcements') ?>" class="sidebar-link <?= isActive('/admin/announcements', true) ?>">
            <i class="ph ph-megaphone sidebar-link-icon"></i>
            <span>Announcements</span>
        </a>
        <a href="<?= url('/admin/posts') ?>" class="sidebar-link <?= isActive('/admin/posts', true) ?>">
            <i class="ph ph-newspaper sidebar-link-icon"></i>
            <span>Posts</span>
        </a>
    </nav>
    
    <div class="sidebar-footer">
        <a href="<?= url('/admin/profile') ?>" class="sidebar-user">
            <div class="avatar avatar-sm">
                <?php if (!empty($adminUser['avatar'])): ?>
                    <img src="<?= url('/public/uploads/avatars/' . htmlspecialchars($adminUser['avatar'])) ?>" alt="Avatar" class="avatar-img">
                <?php else: ?>
                    <?= strtoupper(substr($adminUser['first_name'] ?? 'A', 0, 1)) ?>
                <?php endif; ?>
            </div>
            <div class="sidebar-user-info">
                <span class="sidebar-user-name"><?= htmlspecialchars($adminUser['first_name'] ?? 'Admin') ?></span>
                <span class="sidebar-user-role"><?= htmlspecialchars($adminUser['role'] ?? 'admin') ?></span>
            </div>
        </a>
        <form action="<?= url('/logout') ?>" method="POST">
            <input type="hidden" name="csrf_token" value="<?= Session::generateCsrfToken() ?>">
            <button type="submit" class="sidebar-logout-btn">Logout</button>
        </form>
    </div>
</aside>
