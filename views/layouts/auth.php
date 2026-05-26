<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?? 'Auth - MARU' ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <link rel="stylesheet" href="<?= url('/public/css/design-system.css') ?>">
    <link rel="stylesheet" href="<?= url('/public/css/components.css') ?>">
    <link rel="stylesheet" href="<?= url('/public/css/pages.css') ?>">
</head>
<body class="auth-body">
    <div class="auth-page-container <?= $authContainerClass ?? '' ?>">
        <?php include __DIR__ . '/../partials/alerts.php'; ?>
        <?= $content ?? '' ?>
    </div>
</body>
</html>
