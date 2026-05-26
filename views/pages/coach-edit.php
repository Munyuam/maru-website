<div class="container py-8">
    <div class="page-header mb-6">
        <h1 class="page-title">Edit Profile</h1>
        <a  href="<?= url('/coach/profile') ?>"  class="btn btn-ghost">
            <i class="ph ph-arrow-left mr-2"></i> Back to Profile
        </a>
    </div>

    <form  action="<?= url('/coach/edit') ?>"  method="POST" enctype="multipart/form-data">
        <input type="hidden" name="csrf_token" value="<?= \App\Helpers\Session::generateCsrfToken() ?>">

        <!-- Account Details -->
        <div class="card max-w-2xl mb-6">
            <div class="card-header">
                <h3 class="heading-4 m-0">Account Details</h3>
            </div>
            <div class="card-body">
                <div class="flex items-center gap-6 mb-6 pb-6" style="border-bottom: 1px solid var(--color-border);">
                    <div class="flex-center" style="width: 64px; height: 64px; border-radius: var(--radius-full); background: var(--color-primary); color: white; font-size: 1.5rem; font-weight: 700; flex-shrink: 0; overflow: hidden;">
                        <?php if (!empty($coach['avatar'])): ?>
                            <img  src="<?= url('/public/uploads/avatars/' . htmlspecialchars($coach['avatar'])) ?>"  alt="Avatar" style="width: 100%; height: 100%; object-fit: cover;">
                        <?php else: ?>
                            <?= strtoupper(substr($coach['first_name'] ?? 'C', 0, 1)) ?><?= strtoupper(substr($coach['last_name'] ?? '', 0, 1)) ?>
                        <?php endif; ?>
                    </div>
                    <div>
                        <label class="form-label text-sm" for="avatar">Profile Photo</label>
                        <input class="form-input" type="file" id="avatar" name="avatar" accept="image/jpeg,image/png">
                        <span class="text-xs text-muted block mt-1">Allowed: JPG, PNG. Max 5MB.</span>
                    </div>
                </div>
                <div class="grid grid-2 gap-4">
                    <div class="form-group">
                        <label class="form-label" for="first_name">First Name</label>
                        <input class="form-input" type="text" id="first_name" name="first_name" value="<?= htmlspecialchars($coach['first_name'] ?? '') ?>" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="last_name">Last Name</label>
                        <input class="form-input" type="text" id="last_name" name="last_name" value="<?= htmlspecialchars($coach['last_name'] ?? '') ?>" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="email">Email</label>
                        <input class="form-input" type="email" id="email" name="email" value="<?= htmlspecialchars($coach['email'] ?? '') ?>" required>
                    </div>
                </div>
            </div>
        </div>

        <!-- Coaching Info -->
        <div class="card max-w-2xl mb-6">
            <div class="card-header">
                <h3 class="heading-4 m-0">Coaching Information</h3>
            </div>
            <div class="card-body">
                <div class="grid grid-2 gap-4">
                    <div class="form-group">
                        <label class="form-label" for="phone">Phone</label>
                        <input class="form-input" type="tel" id="phone" name="phone" value="<?= htmlspecialchars($coach['phone'] ?? '') ?>" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="date_of_birth">Date of Birth</label>
                        <input class="form-input" type="date" id="date_of_birth" name="date_of_birth" value="<?= htmlspecialchars($coach['date_of_birth'] ?? '') ?>">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="qualification">Qualification</label>
                        <input class="form-input" type="text" id="qualification" name="qualification" value="<?= htmlspecialchars($coach['qualification'] ?? '') ?>">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="years_experience">Years of Experience</label>
                        <input class="form-input" type="number" id="years_experience" name="years_experience" min="0" value="<?= htmlspecialchars($coach['years_experience'] ?? '0') ?>">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="coaching_specialty">Coaching Specialty</label>
                        <input class="form-input" type="text" id="coaching_specialty" name="coaching_specialty" value="<?= htmlspecialchars($coach['coaching_specialty'] ?? '') ?>">
                    </div>
                    <div class="form-group" style="grid-column: span 2;">
                        <label class="form-label" for="address">Address</label>
                        <textarea class="form-input" id="address" name="address" rows="2"><?= htmlspecialchars($coach['address'] ?? '') ?></textarea>
                    </div>
                </div>
            </div>
        </div>

        <!-- Change Password -->
        <div class="card max-w-2xl mb-6">
            <div class="card-header">
                <h3 class="heading-4 m-0">Change Password</h3>
            </div>
            <div class="card-body">
                <p class="text-muted text-sm mb-4">Leave blank to keep your current password.</p>
                <div class="grid grid-2 gap-4">
                    <div class="form-group">
                        <label class="form-label" for="current_password">Current Password</label>
                        <input class="form-input" type="password" id="current_password" name="current_password">
                    </div>
                    <div></div>
                    <div class="form-group">
                        <label class="form-label" for="new_password">New Password</label>
                        <input class="form-input" type="password" id="new_password" name="new_password" minlength="8">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="confirm_password">Confirm New Password</label>
                        <input class="form-input" type="password" id="confirm_password" name="confirm_password" minlength="8">
                    </div>
                </div>
            </div>
        </div>

        <div class="flex gap-4 max-w-2xl">
            <button type="submit" class="btn btn-primary">Save Changes</button>
            <a  href="<?= url('/coach/profile') ?>"  class="btn btn-ghost">Cancel</a>
        </div>
    </form>
</div>
