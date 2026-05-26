<?php
$errors = $errors ?? [];
?>
<form method="POST" action="/login">
    <input type="hidden" name="csrf_token" value="<?= \App\Helpers\Session::generateCsrfToken() ?>">
    
    <?php if (!empty($errors)): ?>
        <div style="color: red; margin-bottom: 1rem;">
            <?php foreach ($errors as $error): ?>
                <p><?= htmlspecialchars($error) ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <div class="form-group">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-input" required>
    </div>
    
    <div class="form-group" style="margin-top: 1rem;">
        <label class="form-label">Password</label>
        <input type="password" name="password" class="form-input" required>
    </div>
    
    <div style="margin-top: 1.5rem;">
        <button type="submit" class="btn btn-primary" style="width:100%">Sign In</button>
    </div>
    
    <div class="auth-footer" style="margin-top: 1rem; text-align: center;">
        Don't have an account? <a href="/register">Register here</a>
    </div>
</form>
