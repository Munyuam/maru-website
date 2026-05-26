<?php
$errors = $errors ?? [];
?>
<div class="login-wrapper">
    <div class="login-logo-wrapper">
        <div class="login-logo-circle">
            <img src="<?= url('/public/assets/logo.png') ?>" alt="MARU Logo" class="login-logo-img">
        </div>
    </div>
    
    <h2 class="login-heading">LOGIN</h2>
    
    <form method="POST" action="<?= url('/login') ?>" class="login-form">
        <input type="hidden" name="csrf_token" value="<?= \App\Helpers\Session::generateCsrfToken() ?>">

        <?php if (!empty($errors)): ?>
            <div class="alert alert-error mb-4">
                <?php foreach ($errors as $error): ?>
                    <p><?= htmlspecialchars($error) ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <div class="form-group">
            <label class="form-label login-form-label">EMAIL</label>
            <input type="email" name="email" class="form-input login-form-input" required value="<?= htmlspecialchars(\App\Helpers\Session::getOld('email') ?? '') ?>">
        </div>

        <div class="form-group">
            <label class="form-label login-form-label">PASSWORD</label>
            <input type="password" name="password" class="form-input login-form-input" required>
        </div>

        <div class="login-buttons-row">
            <button type="button" class="btn btn-forgot" onclick="alert('Password reset functionality is under maintenance. Please contact administrator.')">Forgot Password?</button>
            <button type="submit" class="btn btn-login-submit">Login</button>
        </div>

        <div class="login-footer">
            Don't have an account? <a href="<?= url('/register') ?>">Register here</a>
        </div>
        
        <div class="mt-4 text-center">
            <a href="<?= url('/') ?>" style="color: #ffffff; font-weight: 600; font-size: 0.875rem; text-decoration: none; text-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);">← Back to Home</a>
        </div>
    </form>
</div>
