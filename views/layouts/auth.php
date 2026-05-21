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
    <link rel="stylesheet" href="/public/css/design-system.css">
    <link rel="stylesheet" href="/public/css/components.css">
    <link rel="stylesheet" href="/public/css/pages.css">
</head>
<body>
    <div class="auth-wrapper">
        <div class="auth-card">
            <div class="auth-logo">
                <div class="text-4xl">🏉</div>
                <h1 class="heading-3 text-gradient">MARU Portal</h1>
            </div>
            
            <?php include __DIR__ . '/../partials/alerts.php'; ?>
            
            <?= $content ?? '' ?>
            
            <div class="mt-6 text-center">
                <a href="/" class="btn btn-ghost btn-sm">← Back to Home</a>
            </div>
        </div>
    </div>
</body>
</html>
