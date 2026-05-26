<?php
$authContainerClass = 'register-container-wide';
$errors = $errors ?? [];
?>
<div class="register-wrapper">
    <div class="register-logo-wrapper" style="margin-bottom: 1.5rem;">
        <div class="register-logo-circle" style="width: 100px; height: 100px; border-width: 3px;">
            <img src="<?= url('/public/assets/logo.png') ?>" alt="MARU Logo" class="register-logo-img" style="width: 80px; height: 80px;">
        </div>
    </div>
    
    <div class="register-form-card">
        <h2 class="login-heading" style="margin-bottom: 0.5rem; font-size: 2rem;">PLAYER REGISTRATION</h2>
        <p class="text-center mb-6" style="color: #ffffff; font-family: var(--font-serif), Georgia, serif; font-style: italic; font-size: 1.1rem; text-shadow: 0 1px 2px rgba(0,0,0,0.1);">Join the MARU Rugby Union family</p>
        
        <form method="POST" action="<?= url('/register/player') ?>" enctype="multipart/form-data">
            <input type="hidden" name="csrf_token" value="<?= \App\Helpers\Session::generateCsrfToken() ?>">
            
            <?php if (!empty($errors)): ?>
                <div class="alert alert-error mb-4">
                    <?php foreach ($errors as $error): ?>
                        <p><?= htmlspecialchars($error) ?></p>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            
            <h3 style="color: #ffffff; font-family: var(--font-serif), Georgia, serif; font-style: italic; font-size: 1.2rem; font-weight: 700; margin-bottom: 1rem; border-bottom: 1px solid rgba(255,255,255,0.3); padding-bottom: 0.25rem;">Personal Information</h3>
            
            <div class="grid grid-2 gap-4">
                <div class="form-group">
                    <label class="form-label login-form-label" for="first_name">FIRST NAME</label>
                    <input class="form-input login-form-input" type="text" id="first_name" name="first_name" required value="<?= htmlspecialchars(\App\Helpers\Session::getOld('first_name') ?? '') ?>">
                </div>
                <div class="form-group">
                    <label class="form-label login-form-label" for="last_name">LAST NAME</label>
                    <input class="form-input login-form-input" type="text" id="last_name" name="last_name" required value="<?= htmlspecialchars(\App\Helpers\Session::getOld('last_name') ?? '') ?>">
                </div>
            </div>
            
            <div class="form-group">
                <label class="form-label login-form-label" for="email">EMAIL ADDRESS</label>
                <input class="form-input login-form-input" type="email" id="email" name="email" required value="<?= htmlspecialchars(\App\Helpers\Session::getOld('email') ?? '') ?>">
            </div>
            
            <div class="form-group">
                <label class="form-label login-form-label" for="password">PASSWORD</label>
                <input class="form-input login-form-input" type="password" id="password" name="password" required minlength="8">
            </div>

            <div class="form-group">
                <label class="form-label login-form-label" for="avatar">PROFILE PHOTO</label>
                <input class="form-input login-form-input" type="file" id="avatar" name="avatar" accept="image/jpeg,image/png">
                <span class="text-xs block mt-1" style="color: rgba(255,255,255,0.8);">Optional. Allowed: JPG, PNG. Max 5MB.</span>
            </div>
            
            <h3 style="color: #ffffff; font-family: var(--font-serif), Georgia, serif; font-style: italic; font-size: 1.2rem; font-weight: 700; margin-top: 1.5rem; margin-bottom: 1rem; border-bottom: 1px solid rgba(255,255,255,0.3); padding-bottom: 0.25rem;">Rugby Information</h3>
            
            <div class="grid grid-2 gap-4">
                <div class="form-group">
                    <label class="form-label login-form-label" for="date_of_birth">DATE OF BIRTH</label>
                    <input class="form-input login-form-input" type="date" id="date_of_birth" name="date_of_birth" required value="<?= htmlspecialchars(\App\Helpers\Session::getOld('date_of_birth') ?? '') ?>">
                </div>
                <div class="form-group">
                    <label class="form-label login-form-label" for="gender">GENDER</label>
                    <select class="form-input login-form-input" id="gender" name="gender" required>
                        <option value="">Select Gender</option>
                        <option value="male" <?= (\App\Helpers\Session::getOld('gender') === 'male') ? 'selected' : '' ?>>Male</option>
                        <option value="female" <?= (\App\Helpers\Session::getOld('gender') === 'female') ? 'selected' : '' ?>>Female</option>
                        <option value="other" <?= (\App\Helpers\Session::getOld('gender') === 'other') ? 'selected' : '' ?>>Other</option>
                    </select>
                </div>
            </div>
            
            <div class="grid grid-2 gap-4">
                <div class="form-group">
                    <label class="form-label login-form-label" for="nationality">NATIONALITY</label>
                    <input class="form-input login-form-input" type="text" id="nationality" name="nationality" required value="<?= htmlspecialchars(\App\Helpers\Session::getOld('nationality') ?? '') ?>">
                </div>
                <div class="form-group">
                    <label class="form-label login-form-label" for="position">PREFERRED POSITION</label>
                    <select class="form-input login-form-input" id="position" name="position" required>
                        <option value="">Select Position</option>
                        <option value="forward" <?= (\App\Helpers\Session::getOld('position') === 'forward') ? 'selected' : '' ?>>Forward</option>
                        <option value="back" <?= (\App\Helpers\Session::getOld('position') === 'back') ? 'selected' : '' ?>>Back</option>
                    </select>
                </div>
            </div>
            
            <div class="form-group">
                <label class="form-label login-form-label" for="phone">PHONE NUMBER</label>
                <input class="form-input login-form-input" type="tel" id="phone" name="phone" required value="<?= htmlspecialchars(\App\Helpers\Session::getOld('phone') ?? '') ?>">
            </div>
            
            <div class="login-buttons-row">
                <a href="<?= url('/register') ?>" class="btn btn-forgot" style="text-decoration: none; line-height: 1.5;">Cancel</a>
                <button type="submit" class="btn btn-login-submit">Register as Player</button>
            </div>
        </form>
        
        <div class="text-center mt-6">
            <p style="color: #ffffff; font-size: 0.875rem; text-shadow: 0 1px 2px rgba(0,0,0,0.1);">Already have an account? <a href="<?= url('/login') ?>" style="color: #ffffff; font-weight:700; text-decoration: underline;">Back to Login</a></p>
        </div>
    </div>
    
    <div class="mt-6 text-center">
        <a href="<?= url('/') ?>" style="color: #ffffff; font-weight: 600; font-size: 0.875rem; text-decoration: none; text-shadow: 0 1px 2px rgba(0,0,0,0.1);">← Back to Home</a>
    </div>
</div>
