<div class="page-header mb-4">
    <div class="header-content">
        <h1 class="text-2xl font-bold">My Profile</h1>
        <p class="text-muted">Manage your account settings and preferences</p>
    </div>
</div>

<div class="grid grid-2 gap-6">
    <div class="card shadow-sm border-0">
        <div class="card-body p-6">
            <h2 class="text-lg font-bold mb-4">Profile Information</h2>
            <form action="/admin/profile/update" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="csrf_token" value="<?= \App\Helpers\Session::generateCsrfToken() ?>">
                
                <div class="flex items-center gap-4 mb-6">
                    <div class="avatar-preview" id="avatarPreview">
                        <?php if (!empty($user['avatar'])): ?>
                            <img src="/public/uploads/avatars/<?= htmlspecialchars($user['avatar']) ?>" alt="Avatar" class="avatar-img" loading="lazy">
                        <?php else: ?>
                            <div class="avatar-placeholder">
                                <?= strtoupper(substr($user['first_name'] ?? 'A', 0, 1)) ?><?= strtoupper(substr($user['last_name'] ?? '', 0, 1)) ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div>
                        <label for="avatar" class="btn btn-sm btn-outline-primary cursor-pointer">
                            Change Avatar
                        </label>
                        <input type="file" id="avatar" name="avatar" accept="image/jpeg,image/png,image/jpg" class="hidden" onchange="previewAvatar(this)">
                        <p class="text-xs text-muted mt-1">JPG, PNG. Max 5MB</p>
                    </div>
                </div>

                <div class="grid grid-2 gap-4 mb-4">
                    <div>
                        <label for="first_name" class="form-label">First Name</label>
                        <input type="text" id="first_name" name="first_name" class="form-input" value="<?= htmlspecialchars($user['first_name'] ?? '') ?>" required>
                    </div>
                    <div>
                        <label for="last_name" class="form-label">Last Name</label>
                        <input type="text" id="last_name" name="last_name" class="form-input" value="<?= htmlspecialchars($user['last_name'] ?? '') ?>" required>
                    </div>
                </div>

                <div class="mb-4">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" id="email" name="email" class="form-input" value="<?= htmlspecialchars($user['email'] ?? '') ?>" required>
                </div>

                <div class="mb-4">
                    <label for="phone" class="form-label">Phone</label>
                    <input type="tel" id="phone" name="phone" class="form-input" value="<?= htmlspecialchars($user['phone'] ?? '') ?>">
                </div>

                <div class="mb-4">
                    <label class="form-label">Role</label>
                    <div class="form-input-static">
                        <span class="badge badge-primary rounded-pill px-3 py-1"><?= htmlspecialchars($user['role'] ?? 'admin') ?></span>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Save Changes</button>
            </form>
        </div>
    </div>

    <div>
        <div class="card shadow-sm border-0 mb-6">
            <div class="card-body p-6">
                <h2 class="text-lg font-bold mb-4">Change Password</h2>
                <form action="/admin/profile/password" method="POST">
                    <input type="hidden" name="csrf_token" value="<?= \App\Helpers\Session::generateCsrfToken() ?>">
                    
                    <div class="mb-4">
                        <label for="current_password" class="form-label">Current Password</label>
                        <input type="password" id="current_password" name="current_password" class="form-input" required>
                    </div>

                    <div class="mb-4">
                        <label for="new_password" class="form-label">New Password</label>
                        <input type="password" id="new_password" name="new_password" class="form-input" required minlength="8">
                        <p class="text-xs text-muted mt-1">Minimum 8 characters</p>
                    </div>

                    <div class="mb-4">
                        <label for="confirm_password" class="form-label">Confirm New Password</label>
                        <input type="password" id="confirm_password" name="confirm_password" class="form-input" required minlength="8">
                    </div>

                    <button type="submit" class="btn btn-primary">Update Password</button>
                </form>
            </div>
        </div>

        <div class="card shadow-sm border-0 mb-6">
            <div class="card-body p-6">
                <h2 class="text-lg font-bold mb-4">Admin Management</h2>
                <a href="/admin/admins/create" class="btn btn-outline-primary w-full justify-center"><i class="ph ph-shield-plus mr-2"></i> Add New Admin</a>
            </div>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body p-6">
                <h2 class="text-lg font-bold mb-4">Account Info</h2>
                <div class="info-group mb-3">
                    <label class="text-sm text-muted block">Last Login</label>
                    <div class="font-medium"><?= htmlspecialchars($user['last_login'] ?? 'N/A') ?></div>
                </div>
                <div class="info-group mb-3">
                    <label class="text-sm text-muted block">Member Since</label>
                    <div class="font-medium"><?= htmlspecialchars($user['created_at'] ?? 'N/A') ?></div>
                </div>
                <div class="info-group">
                    <label class="text-sm text-muted block">Account Status</label>
                    <div>
                        <?php if (!empty($user['is_active'])): ?>
                            <span class="badge badge-success">Active</span>
                        <?php else: ?>
                            <span class="badge badge-danger">Inactive</span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.avatar-preview {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    overflow: hidden;
    background: var(--color-primary);
    display: flex;
    align-items: center;
    justify-content: center;
}

.avatar-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.avatar-placeholder {
    color: white;
    font-size: 1.5rem;
    font-weight: 700;
}

.hidden {
    display: none;
}

.cursor-pointer {
    cursor: pointer;
}

.form-label {
    display: block;
    font-size: 0.875rem;
    font-weight: 500;
    color: var(--color-text-secondary);
    margin-bottom: 0.375rem;
}

.form-input {
    width: 100%;
    padding: 0.625rem 0.875rem;
    border: 1px solid var(--color-border);
    border-radius: var(--radius-md);
    font-size: 0.875rem;
    font-family: var(--font-sans);
    transition: border-color var(--transition-fast);
}

.form-input:focus {
    outline: none;
    border-color: var(--color-primary);
    box-shadow: 0 0 0 3px var(--color-primary-light);
}

.form-input-static {
    padding: 0.625rem 0;
}

.btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 0.625rem 1.25rem;
    border-radius: var(--radius-md);
    font-size: 0.875rem;
    font-weight: 500;
    cursor: pointer;
    transition: all var(--transition-fast);
    border: none;
}

.btn-primary {
    background: var(--color-primary);
    color: white;
}

.btn-primary:hover {
    background: var(--color-primary-hover);
}

.btn-outline-primary {
    background: transparent;
    border: 1px solid var(--color-primary);
    color: var(--color-primary);
}

.btn-outline-primary:hover {
    background: var(--color-primary);
    color: white;
}

.btn-sm {
    padding: 0.375rem 0.75rem;
    font-size: 0.8125rem;
}

.badge {
    display: inline-block;
    padding: 0.25rem 0.625rem;
    border-radius: 9999px;
    font-size: 0.75rem;
    font-weight: 500;
}

.badge-primary {
    background: var(--color-primary-light);
    color: var(--color-primary);
}

.badge-success {
    background: rgba(16, 185, 129, 0.1);
    color: #10b981;
}

.badge-danger {
    background: rgba(239, 68, 68, 0.1);
    color: #ef4444;
}

.alert {
    padding: 0.75rem 1rem;
    border-radius: var(--radius-md);
    font-size: 0.875rem;
}

.alert-success {
    background: rgba(16, 185, 129, 0.1);
    color: #10b981;
    border: 1px solid rgba(16, 185, 129, 0.2);
}

.alert-error {
    background: rgba(239, 68, 68, 0.1);
    color: #ef4444;
    border: 1px solid rgba(239, 68, 68, 0.2);
}

.grid {
    display: grid;
}

.grid-2 {
    grid-template-columns: repeat(2, 1fr);
}

@media (max-width: 768px) {
    .grid-2 {
        grid-template-columns: 1fr;
    }
}

.gap-4 {
    gap: 1rem;
}

.gap-6 {
    gap: 1.5rem;
}

.mb-3 {
    margin-bottom: 0.75rem;
}

.mb-4 {
    margin-bottom: 1rem;
}

.mb-6 {
    margin-bottom: 1.5rem;
}

.mt-1 {
    margin-top: 0.25rem;
}

.text-xs {
    font-size: 0.75rem;
}

.text-sm {
    font-size: 0.875rem;
}

.text-muted {
    color: var(--color-text-muted);
}

.font-medium {
    font-weight: 500;
}

.font-bold {
    font-weight: 700;
}

.text-lg {
    font-size: 1.125rem;
}
</style>

<script>
function previewAvatar(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById('avatarPreview');
            preview.innerHTML = '<img src="' + e.target.result + '" alt="Avatar" class="avatar-img">';
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
