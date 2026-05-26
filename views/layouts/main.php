<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="MARU Online Player Registration System - Register players for Malawi Rugby Union">
    <title><?= $pageTitle ?? 'MARU Player Registration' ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <link rel="stylesheet" href="<?= url('/public/css/design-system.css') ?>">
    <link rel="stylesheet" href="<?= url('/public/css/components.css') ?>">
    <link rel="stylesheet" href="<?= url('/public/css/pages.css') ?>">
    <link rel="stylesheet" href="<?= url('/public/css/admin.css') ?>">
    <script>
        // Check for saved user preference, if any, on load of the website
        let theme = localStorage.getItem('theme');
        if (!theme) {
            theme = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
        }
        document.documentElement.setAttribute('data-theme', theme);
    </script>
</head>
<body>
    <?php if (!isset($hideHeader) || !$hideHeader): ?>
        <?php include __DIR__ . '/../partials/header.php'; ?>
    <?php endif; ?>
    
    <main>
        <?php include __DIR__ . '/../partials/alerts.php'; ?>
        <?= $content ?? '' ?>
    </main>
    
    <?php if (!isset($hideFooter) || !$hideFooter): ?>
        <?php include __DIR__ . '/../partials/footer.php'; ?>
    <?php endif; ?>
    
    <script src="<?= url('/public/js/app.js') ?>"></script>
    <?php if (isset($scripts)): ?>
        <?php foreach ($scripts as $script): ?>
            <script src="<?= url($script) ?>"></script>
        <?php endforeach; ?>
    <?php endif; ?>
</body>
</html>
