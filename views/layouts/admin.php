<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?? 'Admin Dashboard - MARU' ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <link rel="stylesheet" href="/public/css/design-system.css">
    <link rel="stylesheet" href="/public/css/components.css">
    <link rel="stylesheet" href="/public/css/pages.css">
</head>
<body>
    <div class="dashboard-layout">
        <?php include __DIR__ . '/../partials/sidebar.php'; ?>
        
        <div class="dashboard-content">
            <header class="dashboard-topbar">
                <div class="heading-4"><?= $pageTitle ?? 'Dashboard' ?></div>
                <div class="flex items-center gap-4">
                    <div class="avatar avatar-sm">A</div>
                </div>
            </header>
            
            <main class="dashboard-main">
                <?php include __DIR__ . '/../partials/alerts.php'; ?>
                <?= $content ?? '' ?>
            </main>
        </div>
    </div>
</body>
</html>
