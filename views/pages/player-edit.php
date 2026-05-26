<?php $layout = 'main'; ?>
<div class="container py-8">
    <div class="page-header mb-6">
        <h1 class="page-title">Edit Profile</h1>
        <a  href="<?= url('/player/profile') ?>"  class="btn btn-ghost">
            <i class="ph ph-arrow-left mr-2"></i> Back to Profile
        </a>
    </div>

    <form  action="<?= url('/player/profile/edit') ?>"  method="POST" enctype="multipart/form-data">
        <input type="hidden" name="csrf_token" value="<?= \App\Helpers\Session::generateCsrfToken() ?>">

        <!-- Account Details -->
        <div class="card max-w-2xl mb-6">
            <div class="card-header">
                <h3 class="heading-4 m-0">Account Details</h3>
            </div>
            <div class="card-body">
                <div class="flex items-center gap-6 mb-6 pb-6" style="border-bottom: 1px solid var(--color-border);">
                    <div class="flex-center" style="width: 64px; height: 64px; border-radius: var(--radius-full); background: var(--color-primary); color: white; font-size: 1.5rem; font-weight: 700; flex-shrink: 0;">
                        <?php if (!empty($player['avatar'])): ?>
                            <img  src="<?= url('/public/uploads/avatars/' . htmlspecialchars($player['avatar'])) ?>"  alt="Avatar" style="width: 100%; height: 100%; border-radius: var(--radius-full); object-fit: cover;">
                        <?php else: ?>
                            <?= strtoupper(substr($player['first_name'] ?? 'P', 0, 1)) ?><?= strtoupper(substr($player['last_name'] ?? '', 0, 1)) ?>
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
                        <input class="form-input" type="text" id="first_name" name="first_name" value="<?= htmlspecialchars($player['first_name'] ?? '') ?>" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="last_name">Last Name</label>
                        <input class="form-input" type="text" id="last_name" name="last_name" value="<?= htmlspecialchars($player['last_name'] ?? '') ?>" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="email">Email</label>
                        <input class="form-input" type="email" id="email" name="email" value="<?= htmlspecialchars($player['email'] ?? '') ?>" required>
                    </div>
                </div>
            </div>
        </div>

        <!-- Personal Details -->
        <div class="card max-w-2xl mb-6">
            <div class="card-header">
                <h3 class="heading-4 m-0">Personal Details</h3>
            </div>
            <div class="card-body">
                <div class="grid grid-2 gap-4">
                    <div class="form-group">
                        <label class="form-label" for="date_of_birth">Date of Birth</label>
                        <input class="form-input" type="date" id="date_of_birth" name="date_of_birth" value="<?= htmlspecialchars($player['date_of_birth'] ?? '') ?>" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="gender">Gender</label>
                        <select class="form-input" id="gender" name="gender" required>
                            <option value="">Select Gender</option>
                            <option value="male" <?= ($player['gender'] ?? '') === 'male' ? 'selected' : '' ?>>Male</option>
                            <option value="female" <?= ($player['gender'] ?? '') === 'female' ? 'selected' : '' ?>>Female</option>
                            <option value="other" <?= ($player['gender'] ?? '') === 'other' ? 'selected' : '' ?>>Other</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="nationality">Nationality</label>
                        <input class="form-input" type="text" id="nationality" name="nationality" value="<?= htmlspecialchars($player['nationality'] ?? '') ?>" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="phone">Phone Number</label>
                        <input class="form-input" type="tel" id="phone" name="phone" value="<?= htmlspecialchars($player['phone'] ?? '') ?>" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="position">Preferred Position</label>
                        <select class="form-input" id="position" name="position" required>
                            <option value="">Select Position</option>
                            <option value="forward" <?= ($player['position'] ?? '') === 'forward' ? 'selected' : '' ?>>Forward</option>
                            <option value="back" <?= ($player['position'] ?? '') === 'back' ? 'selected' : '' ?>>Back</option>
                        </select>
                    </div>
                    <div class="form-group" style="grid-column: span 2;">
                        <label class="form-label" for="address">Address</label>
                        <textarea class="form-input" id="address" name="address" rows="2"><?= htmlspecialchars($player['address'] ?? '') ?></textarea>
                    </div>
                </div>
            </div>
        </div>

        <!-- Playing Experience -->
        <div class="card max-w-2xl mb-6">
            <div class="card-header">
                <h3 class="heading-4 m-0">Playing Experience</h3>
            </div>
            <div class="card-body">
                <div class="grid grid-2 gap-4">
                    <div class="form-group">
                        <label class="form-label" for="playing_experience">Years of Experience</label>
                        <input class="form-input" type="number" id="playing_experience" name="playing_experience" min="0" value="<?= htmlspecialchars($player['playing_experience'] ?? '0') ?>">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="previous_clubs">Previous Clubs</label>
                        <input class="form-input" type="text" id="previous_clubs" name="previous_clubs" value="<?= htmlspecialchars($player['previous_clubs'] ?? '') ?>">
                    </div>
                </div>
            </div>
        </div>

        <!-- Emergency Contact -->
        <div class="card max-w-2xl mb-6">
            <div class="card-header">
                <h3 class="heading-4 m-0">Emergency Contact</h3>
            </div>
            <div class="card-body">
                <div class="grid grid-2 gap-4">
                    <div class="form-group">
                        <label class="form-label" for="emergency_contact_name">Contact Name</label>
                        <input class="form-input" type="text" id="emergency_contact_name" name="emergency_contact_name" value="<?= htmlspecialchars($player['emergency_contact_name'] ?? '') ?>">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="emergency_contact_phone">Contact Phone</label>
                        <input class="form-input" type="tel" id="emergency_contact_phone" name="emergency_contact_phone" value="<?= htmlspecialchars($player['emergency_contact_phone'] ?? '') ?>">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="emergency_contact_relationship">Relationship</label>
                        <input class="form-input" type="text" id="emergency_contact_relationship" name="emergency_contact_relationship" value="<?= htmlspecialchars($player['emergency_contact_relationship'] ?? '') ?>">
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
            <a  href="<?= url('/player/profile') ?>"  class="btn btn-ghost">Cancel</a>
        </div>
    </form>
</div>
