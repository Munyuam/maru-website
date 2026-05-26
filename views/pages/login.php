<div class="login-wrapper" style="width: 100%; max-width: 400px; margin: 0 auto; padding-top: 2rem;">
    
    <div class="login-logo-wrapper" style="margin-bottom: 1.5rem; text-align: center;">
        <div class="login-logo-circle" style="background: #ffffff; border: 5px solid #ffffff; outline: 2px solid rgba(255, 255, 255, 0.25); width: 150px; height: 150px; border-radius: 50%; margin: 0 auto; display: flex; align-items: center; justify-content: center; box-shadow: 0 10px 25px rgba(0,0,0,0.15);">
            <img src="<?= url('/public/assets/logo.png') ?>" alt="MARU Logo" style="width: 125px; height: 125px; object-fit: contain;">
        </div>
    </div>
    
    <h2 class="login-heading" style="color: #000000; margin-bottom: 2rem; font-family: sans-serif; font-weight: 800; font-size: 1.5rem; text-align: center; letter-spacing: 0.05em;">LOGIN</h2>
    
    <form method="POST" action="<?= url('/login') ?>" style="text-align: left;">
        <input type="hidden" name="csrf_token" value="<?= \App\Helpers\Session::generateCsrfToken() ?>">
        
        <?php if (!empty($errors)): ?>
            <div class="alert alert-error">
                <div>
                <?php foreach ($errors as $error): ?>
                    <p><?= htmlspecialchars($error) ?></p>
                <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>

        <div class="form-group" style="margin-bottom: 1.5rem;">
            <label class="form-label" style="color: #000000; font-weight: 800; font-family: sans-serif; font-size: 0.85rem; margin-bottom: 0.5rem; display: block; letter-spacing: 0.05em; text-transform: uppercase;">Email</label>
            <input type="email" name="email" required style="background: #ffffff; color: #000000; border: none; border-radius: 4px; padding: 0.75rem 1rem; width: 100%; box-sizing: border-box; font-size: 1rem; box-shadow: 0 2px 4px rgba(0,0,0,0.05) inset;" placeholder="e.g. user@example.com">
        </div>
        
        <div class="form-group" style="margin-bottom: 2rem;">
            <label class="form-label" style="color: #000000; font-weight: 800; font-family: sans-serif; font-size: 0.85rem; margin-bottom: 0.5rem; display: block; letter-spacing: 0.05em; text-transform: uppercase;">Password</label>
            <input type="password" name="password" required style="background: #ffffff; color: #000000; border: none; border-radius: 4px; padding: 0.75rem 1rem; width: 100%; box-sizing: border-box; font-size: 1rem; box-shadow: 0 2px 4px rgba(0,0,0,0.05) inset;" placeholder="Enter your password">
        </div>
        
        <div style="display: flex; justify-content: flex-end; gap: 0.75rem;">
            <button type="button" class="btn btn-forgot" style="background-color: #4b5563; color: #ffffff; font-family: sans-serif; font-weight: 700; font-size: 0.875rem; padding: 0.6rem 1.25rem; border-radius: 4px; border: none; cursor: pointer;">Forgot Password?</button>
            <button type="submit" class="btn btn-login-submit" style="background-color: #000000; color: #ffffff; font-family: sans-serif; font-weight: 700; font-size: 0.875rem; padding: 0.6rem 1.5rem; border-radius: 4px; border: none; cursor: pointer;">Login</button>
        </div>
    </form>
</div>
