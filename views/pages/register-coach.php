<div class="auth-container">
    <div class="auth-card">
        <div class="auth-header">
            <h1 class="auth-title">Coach Registration</h1>
            <p class="auth-subtitle">Join as a coach and lead your team to victory.</p>
        </div>

        <?php if (!empty($errors)): ?>
            <div class="alert alert-error">
                <div>
                <?php foreach ($errors as $error): ?>
                    <p><?= htmlspecialchars($error) ?></p>
                <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>

        <form action="<?= url('/register/coach') ?>" method="POST" class="auth-form" enctype="multipart/form-data">
            <input type="hidden" name="csrf_token" value="<?= \App\Helpers\Session::generateCsrfToken() ?>">
            <div class="form-section">
                <h3 class="section-title">Personal Information</h3>
                
                <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 1rem; margin-bottom: 1rem;">
                    <div class="form-group" style="margin-bottom: 0;">
                        <label for="first_name" class="form-label">First Name</label>
                        <input type="text" id="first_name" name="first_name" class="form-input" placeholder="e.g. Allstar" required>
                    </div>
                    <div class="form-group" style="margin-bottom: 0;">
                        <label for="last_name" class="form-label">Last Name</label>
                        <input type="text" id="last_name" name="last_name" class="form-input" placeholder="e.g. Momba" required>
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 1rem; margin-bottom: 1rem;">
                    <div class="form-group" style="margin-bottom: 0;">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" id="email" name="email" class="form-input" placeholder="e.g. john.doe@example.com" required>
                    </div>
                    <div class="form-group" style="margin-bottom: 0;">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" id="password" name="password" class="form-input" placeholder="Enter your password" required minlength="8">
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 1rem; margin-bottom: 1rem;">
                    <div class="form-group" style="margin-bottom: 0;">
                        <label for="date_of_birth" class="form-label">Date of Birth</label>
                        <input type="date" id="date_of_birth" name="date_of_birth" class="form-input" required>
                    </div>
                    <div class="form-group" style="margin-bottom: 0;">
                        <label for="avatar" class="form-label">Profile Photo</label>
                        <input type="file" id="avatar" name="avatar" class="form-input" accept="image/jpeg,image/png">
                        <span class="text-xs text-muted block mt-1">Optional. Allowed: JPG, PNG. Max 5MB.</span>
                    </div>
                </div>
            </div>

            <div class="form-section">
                <h3 class="section-title">Coaching Information</h3>
                
                <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 1rem; margin-bottom: 1rem;">
                    <div class="form-group" style="margin-bottom: 0;">
                        <label for="qualification" class="form-label">Qualification/Certification</label>
                        <input type="text" id="qualification" name="qualification" class="form-input" placeholder="e.g. Level 2 IRB" required>
                    </div>
                    <div class="form-group" style="margin-bottom: 0;">
                        <label for="years_experience" class="form-label">Years of Experience</label>
                        <input type="number" id="years_experience" name="years_experience" class="form-input" min="0" placeholder="e.g. 5" required>
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 1rem; margin-bottom: 1.5rem;">
                    <div class="form-group" style="margin-bottom: 0;">
                        <label for="coaching_specialty" class="form-label">Coaching Specialty</label>
                        <input type="text" id="coaching_specialty" name="coaching_specialty" class="form-input" placeholder="e.g. Defense, Pitching" required>
                    </div>
                    <div class="form-group" style="margin-bottom: 0;">
                        <label for="team_id" class="form-label">Assign to Team</label>
                        <select id="team_id" name="team_id" class="form-select" required>
                            <option value="">Select a team...</option>
                            <?php if (isset($teams) && is_array($teams)): ?>
                                <?php foreach ($teams as $team): ?>
                                    <option value="<?= htmlspecialchars($team['id']) ?>">
                                        <?= htmlspecialchars($team['name']) ?> (<?= htmlspecialchars($team['division']) ?>)
                                    </option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary btn-block" style="margin: 1rem 1%; background-color: green;color: #ffffff">Register as Coach</button>
        </form>

        <div class="auth-footer">
            <p>Already have an account? <a href="<?= url('/login') ?>" class="auth-link">Log in</a></p>
        </div>
    </div>
</div>
