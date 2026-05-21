<?php $layout = 'main'; ?>
<div class="container">
    <div class="page-header">
        <h1 class="page-title">Edit Profile</h1>
        <a href="/player/profile" class="btn btn-ghost">
            <i class="ph ph-arrow-left mr-2"></i> Back to Profile
        </a>
    </div>

    <div class="card max-w-2xl">
        <div class="card-body">
            <form action="/player/profile/edit" method="POST">
                <input type="hidden" name="csrf_token" value="<?= \App\Helpers\Session::generateCsrfToken() ?>">

                <div class="form-group">
                    <label class="form-label" for="phone">Phone Number</label>
                    <input class="form-input" type="tel" id="phone" name="phone" value="<?= htmlspecialchars($player['phone'] ?? '') ?>" required>
                </div>

                <div class="form-group">
                    <label class="form-label" for="nationality">Nationality</label>
                    <input class="form-input" type="text" id="nationality" name="nationality" value="<?= htmlspecialchars($player['nationality'] ?? '') ?>" required>
                </div>

                <div class="form-group">
                    <label class="form-label" for="position">Preferred Position</label>
                    <select class="form-input" id="position" name="position" required>
                        <option value="">Select Position</option>
                        <option value="forward" <?= ($player['position'] ?? '') === 'forward' ? 'selected' : '' ?>>Forward</option>
                        <option value="back" <?= ($player['position'] ?? '') === 'back' ? 'selected' : '' ?>>Back</option>
                    </select>
                </div>

                <div class="flex gap-4 mt-6">
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                    <a href="/player/profile" class="btn btn-ghost">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
