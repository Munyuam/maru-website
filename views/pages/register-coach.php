<?php
$errors = $errors ?? [];
?>
<div class="register-wrapper">
    <div class="register-logo-wrapper" style="margin-bottom: 1.5rem;">
        <div class="register-logo-circle" style="width: 100px; height: 100px; border-width: 3px;">
            <img src="<?= url('/public/assets/logo.png') ?>" alt="MARU Logo" class="register-logo-img" style="width: 80px; height: 80px;">
        </div>
    </div>
    
    <div class="register-form-card">
        <h2 class="login-heading" style="margin-bottom: 0.5rem; font-size: 2rem;">COACH REGISTRATION</h2>
        <p class="text-center mb-6" style="color: #ffffff; font-family: var(--font-serif), Georgia, serif; font-style: italic; font-size: 1.1rem; text-shadow: 0 1px 2px rgba(0,0,0,0.1);">Join as a coach and lead your team to victory</p>
        
        <form method="POST" action="<?= url('/register/coach') ?>" enctype="multipart/form-data">
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

            <div class="grid grid-2 gap-4">
                <div class="form-group">
                    <label class="form-label login-form-label" for="date_of_birth">DATE OF BIRTH</label>
                    <input class="form-input login-form-input" type="date" id="date_of_birth" name="date_of_birth" required value="<?= htmlspecialchars(\App\Helpers\Session::getOld('date_of_birth') ?? '') ?>">
                </div>
                <div class="form-group">
                    <label class="form-label login-form-label" for="phone">PHONE NUMBER</label>
                    <input class="form-input login-form-input" type="tel" id="phone" name="phone" required value="<?= htmlspecialchars(\App\Helpers\Session::getOld('phone') ?? '') ?>">
                </div>
            </div>

            <div class="form-group">
                <label class="form-label login-form-label" for="avatar">PROFILE PHOTO</label>
                <input class="form-input login-form-input" type="file" id="avatar" name="avatar" accept="image/jpeg,image/png">
                <span class="text-xs block mt-1" style="color: rgba(255,255,255,0.8);">Optional. Allowed: JPG, PNG. Max 5MB.</span>
            </div>
            
            <h3 style="color: #ffffff; font-family: var(--font-serif), Georgia, serif; font-style: italic; font-size: 1.2rem; font-weight: 700; margin-top: 1.5rem; margin-bottom: 1rem; border-bottom: 1px solid rgba(255,255,255,0.3); padding-bottom: 0.25rem;">Coaching Information</h3>
            
            <div class="form-group">
                <label class="form-label login-form-label" for="qualification">QUALIFICATION/CERTIFICATION</label>
                <input class="form-input login-form-input" type="text" id="qualification" name="qualification" required value="<?= htmlspecialchars(\App\Helpers\Session::getOld('qualification') ?? '') ?>">
            </div>

            <div class="grid grid-2 gap-4">
                <div class="form-group">
                    <label class="form-label login-form-label" for="years_experience">YEARS OF EXPERIENCE</label>
                    <input class="form-input login-form-input" type="number" id="years_experience" name="years_experience" min="0" required value="<?= htmlspecialchars(\App\Helpers\Session::getOld('years_experience') ?? '') ?>">
                </div>
                <div class="form-group">
                    <label class="form-label login-form-label" for="coaching_specialty">COACHING SPECIALTY</label>
                    <input class="form-input login-form-input" type="text" id="coaching_specialty" name="coaching_specialty" placeholder="e.g. Defense, Tactics" required value="<?= htmlspecialchars(\App\Helpers\Session::getOld('coaching_specialty') ?? '') ?>">
                </div>
            </div>
            
            <div class="form-group">
                <label class="form-label login-form-label" for="team_id">ASSIGN TO TEAM</label>
                <select id="team_id" name="team_id" class="form-input login-form-input" required>
                    <option value="">Select a team...</option>
                    <?php if (isset($teams) && is_array($teams)): ?>
                        <?php foreach ($teams as $team): ?>
                            <option value="<?= htmlspecialchars((string)$team['id']) ?>" <?= (\App\Helpers\Session::getOld('team_id') == $team['id']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($team['name']) ?> (<?= htmlspecialchars($team['division']) ?>)
                            </option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </div>
            
            <button type="submit" class="btn btn-login-submit w-full mt-4" style="flex: none; display: block;">Register as Coach</button>
        </form>
        
        <div class="text-center mt-6">
            <p style="color: #ffffff; font-size: 0.875rem; text-shadow: 0 1px 2px rgba(0,0,0,0.1);">Already have an account? <a href="<?= url('/login') ?>" style="color: #ffffff; font-weight:700; text-decoration: underline;">Back to Login</a></p>
        </div>
    </div>
    
    <div class="mt-6 text-center">
        <a href="<?= url('/') ?>" style="color: #ffffff; font-weight: 600; font-size: 0.875rem; text-decoration: none; text-shadow: 0 1px 2px rgba(0,0,0,0.1);">← Back to Home</a>
    </div>
</div>
