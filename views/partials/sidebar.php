<?php
use App\Helpers\Session;

$currentPath = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?? '';
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
        <a href="/" class="navbar-brand">
            <svg class="sidebar-logo" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                <circle cx="20" cy="20" r="18" fill="var(--color-primary)" opacity="0.15"/>
                <path d="M20 6C14.5 6 10 9.5 8 14.5L12 18C13.5 15.5 16.5 14 20 14C23.5 14 26.5 15.5 28 18L32 14.5C30 9.5 25.5 6 20 6Z" fill="var(--color-primary)"/>
                <path d="M20 26C16.5 26 13.5 24.5 12 22L8 25.5C10 30.5 14.5 34 20 34C25.5 34 30 30.5 32 25.5L28 22C26.5 24.5 23.5 26 20 26Z" fill="var(--color-primary)"/>
                <ellipse cx="20" cy="20" rx="6" ry="5" fill="var(--color-primary)"/>
                <path d="M14 20L10 17L8 20L10 23L14 20Z" fill="var(--color-primary)" opacity="0.6"/>
                <path d="M26 20L30 17L32 20L30 23L26 20Z" fill="var(--color-primary)" opacity="0.6"/>
            </svg>
            <span class="sidebar-brand-text">MARU Admin</span>
        </a>
    </div>
    
    <nav class="sidebar-nav">
        <a href="/admin" class="sidebar-link <?= isActive('/admin') ?>">
            <i class="ph ph-chart-bar sidebar-link-icon"></i>
            <span>Dashboard</span>
        </a>
        <a href="/admin/players" class="sidebar-link <?= isActive('/admin/players', true) ?>">
            <i class="ph ph-users-three sidebar-link-icon"></i>
            <span>Players</span>
        </a>
        <a href="/admin/teams" class="sidebar-link <?= isActive('/admin/teams', true) ?>">
            <i class="ph ph-trophy sidebar-link-icon"></i>
            <span>Teams</span>
        </a>
        <a href="/admin/coaches" class="sidebar-link <?= isActive('/admin/coaches', true) ?>">
            <i class="ph ph-chalkboard-teacher sidebar-link-icon"></i>
            <span>Coaches</span>
        </a>
        <a href="/admin/documents" class="sidebar-link <?= isActive('/admin/documents', true) ?>">
            <i class="ph ph-file-text sidebar-link-icon"></i>
            <span>Documents</span>
        </a>
        <a href="/admin/announcements" class="sidebar-link <?= isActive('/admin/announcements', true) ?>">
            <i class="ph ph-megaphone sidebar-link-icon"></i>
            <span>Announcements</span>
        </a>
    </nav>
    
    <div class="sidebar-footer">
        <a href="/admin/profile" class="sidebar-user">
            <div class="avatar avatar-sm">
                <?php if (!empty($adminUser['avatar'])): ?>
                    <img src="/public/uploads/avatars/<?= htmlspecialchars($adminUser['avatar']) ?>" alt="Avatar" class="avatar-img">
                <?php else: ?>
                    <?= strtoupper(substr($adminUser['first_name'] ?? 'A', 0, 1)) ?>
                <?php endif; ?>
            </div>
            <div class="sidebar-user-info">
                <span class="sidebar-user-name"><?= htmlspecialchars($adminUser['first_name'] ?? 'Admin') ?></span>
                <span class="sidebar-user-role"><?= htmlspecialchars($adminUser['role'] ?? 'admin') ?></span>
            </div>
        </a>
        <form action="/logout" method="POST">
            <input type="hidden" name="csrf_token" value="<?= Session::generateCsrfToken() ?>">
            <button type="submit" class="sidebar-logout-btn">Logout</button>
        </form>
    </div>
</aside>
