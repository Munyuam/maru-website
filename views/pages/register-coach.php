<div class="auth-container">
    <div class="auth-card">
        <div class="auth-header">
            <h1 class="auth-title">Coach Registration</h1>
            <p class="auth-subtitle">Join as a coach and lead your team to victory.</p>
        </div>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger">
                <?= htmlspecialchars($_SESSION['error']) ?>
                <?php unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>

        <form action="/register/coach" method="POST" class="auth-form">
            <input type="hidden" name="csrf_token" value="<?= \App\Helpers\Session::generateCsrfToken() ?>">
            <div class="form-section">
                <h3 class="section-title">Personal Information</h3>
                <div class="form-row">
                    <div class="form-group">
                        <label for="first_name" class="form-label">First Name</label>
                        <input type="text" id="first_name" name="first_name" class="form-input" required>
                    </div>
                    <div class="form-group">
                        <label for="last_name" class="form-label">Last Name</label>
                        <input type="text" id="last_name" name="last_name" class="form-input" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="email" class="form-label">Email Address</label>
                    <input type="email" id="email" name="email" class="form-input" required>
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" id="password" name="password" class="form-input" required minlength="8">
                </div>

                <div class="form-group">
                    <label for="date_of_birth" class="form-label">Date of Birth</label>
                    <input type="date" id="date_of_birth" name="date_of_birth" class="form-input" required>
                </div>
            </div>

            <div class="form-section">
                <h3 class="section-title">Coaching Information</h3>
                <div class="form-group">
                    <label for="qualification" class="form-label">Qualification/Certification</label>
                    <input type="text" id="qualification" name="qualification" class="form-input" required>
                </div>

                <div class="form-group">
                    <label for="years_experience" class="form-label">Years of Experience</label>
                    <input type="number" id="years_experience" name="years_experience" class="form-input" min="0" required>
                </div>

                <div class="form-group">
                    <label for="coaching_specialty" class="form-label">Coaching Specialty</label>
                    <input type="text" id="coaching_specialty" name="coaching_specialty" class="form-input" placeholder="e.g. Defense, Pitching" required>
                </div>

                <div class="form-group">
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

            <button type="submit" class="btn btn-primary btn-block">Register as Coach</button>
        </form>

        <div class="auth-footer">
            <p>Already have an account? <a href="/login" class="auth-link">Log in</a></p>
        </div>
    </div>
</div>
