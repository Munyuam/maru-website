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

$coachUser = Session::getUser();

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
            <span class="sidebar-brand-text">MARU Coach</span>
        </a>
    </div>

    <nav class="sidebar-nav">
        <a href="<?= url('/coach/profile') ?>" class="sidebar-link <?= isActive('/coach/profile') ?>">
            <i class="ph ph-user-circle sidebar-link-icon"></i>
            <span>My Profile</span>
        </a>
        <a href="<?= url('/coach/team') ?>" class="sidebar-link <?= isActive('/coach/team') ?>">
            <i class="ph ph-users-three sidebar-link-icon"></i>
            <span>My Team</span>
        </a>
        <a href="<?= url('/coach/edit') ?>" class="sidebar-link <?= isActive('/coach/edit') ?>">
            <i class="ph ph-pencil-simple sidebar-link-icon"></i>
            <span>Edit Profile</span>
        </a>
        <a href="<?= url('/coach/announcements') ?>" class="sidebar-link <?= isActive('/coach/announcements') ?>">
            <i class="ph ph-megaphone sidebar-link-icon"></i>
            <span>Announcements</span>
        </a>
    </nav>

    <div class="sidebar-footer">
        <a href="<?= url('/coach/profile') ?>" class="sidebar-user">
            <div class="avatar avatar-sm">
                <?php if (!empty($coachUser['avatar'])): ?>
                    <img src="<?= url('/public/uploads/avatars/' . htmlspecialchars($coachUser['avatar'])) ?>" alt="Avatar" class="avatar-img">
                <?php else: ?>
                    <?= strtoupper(substr($coachUser['first_name'] ?? 'C', 0, 1)) ?>
                <?php endif; ?>
            </div>
            <div class="sidebar-user-info">
                <span class="sidebar-user-name"><?= htmlspecialchars($coachUser['first_name'] ?? 'Coach') ?></span>
                <span class="sidebar-user-role">coach</span>
            </div>
        </a>
        <form action="<?= url('/logout') ?>" method="POST">
            <input type="hidden" name="csrf_token" value="<?= Session::generateCsrfToken() ?>">
            <button type="submit" class="sidebar-logout-btn">Logout</button>
        </form>
    </div>
</aside>
