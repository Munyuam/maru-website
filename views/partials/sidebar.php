<?php
use App\Helpers\Session;

$currentPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$adminUser = Session::getUser();
?>
<aside class="dashboard-sidebar">
    <div class="p-6">
        <a href="/" class="navbar-brand">
            <i class="ph-fill ph-rugby text-2xl text-primary"></i> MALU Admin
        </a>
    </div>
    
    <nav class="mt-6 px-4">
        <ul class="flex-col gap-1 mb-6">
            <li>
                <a href="/admin/documents" class="btn btn-ghost <?= strpos($currentPath, '/admin/documents') === 0 ? 'active' : '' ?>" style="width:100%; justify-content:flex-start;">
                    📄 Documents
                </a>
            </li>
        </ul>
    </nav>
    
    <div style="position: absolute; bottom: 0; width: 100%; padding: 1.5rem; border-top: 1px solid var(--color-border);">
        <div class="flex items-center gap-3 mb-4">
            <div class="avatar avatar-sm"><?= strtoupper(substr($adminUser['first_name'] ?? 'A', 0, 1)) ?></div>
            <div class="text-sm">
                <div class="font-bold"><?= htmlspecialchars($adminUser['first_name'] ?? 'Admin') ?></div>
                <div class="text-xs text-muted text-capitalize"><?= htmlspecialchars($adminUser['role'] ?? 'admin') ?></div>
            </div>
        </div>
        <form action="/logout" method="POST">
            <input type="hidden" name="csrf_token" value="<?= Session::generateCsrfToken() ?>">
            <button type="submit" class="btn btn-outline btn-sm" style="width:100%;">Logout</button>
        </form>
    </div>
</aside>
