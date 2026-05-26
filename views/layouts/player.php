<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?? 'Player Dashboard - MARU' ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <script>let theme=localStorage.getItem('theme');if(!theme){theme=window.matchMedia('(prefers-color-scheme: dark)').matches?'dark':'light'}document.documentElement.setAttribute('data-theme',theme);</script>
    <link rel="stylesheet" href="<?= url('/public/css/design-system.css') ?>">
    <link rel="stylesheet" href="<?= url('/public/css/components.css') ?>">
    <link rel="stylesheet" href="<?= url('/public/css/pages.css') ?>">
    <link rel="stylesheet" href="<?= url('/public/css/admin.css') ?>">
</head>
<body>
    <div class="dashboard-layout">
        <?php include __DIR__ . '/../partials/player-sidebar.php'; ?>

        <div class="dashboard-content">
            <header class="dashboard-topbar">
                <button class="sidebar-toggle" id="sidebar-toggle" aria-label="Toggle sidebar">
                    <i class="ph ph-list"></i>
                </button>
                <div class="heading-4"><?= $pageTitle ?? 'Dashboard' ?></div>
            </header>

            <main class="dashboard-main">
                <?php include __DIR__ . '/../partials/alerts.php'; ?>
                <?= $content ?? '' ?>
            </main>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var toggle = document.getElementById('sidebar-toggle');
            var sidebar = document.querySelector('.dashboard-sidebar');
            if (toggle && sidebar) {
                toggle.addEventListener('click', function() {
                    sidebar.classList.toggle('show');
                });
                document.addEventListener('click', function(e) {
                    if (window.innerWidth <= 768 && !sidebar.contains(e.target) && !toggle.contains(e.target)) {
                        sidebar.classList.remove('show');
                    }
                });
            }
        });
    </script>
</body>
</html>
