<div class="container py-8">
    <div class="page-header mb-6">
        <h1 class="page-title">Edit Profile</h1>
        <a href="/coach/profile" class="btn btn-ghost">
            <i class="ph ph-arrow-left mr-2"></i> Back to Profile
        </a>
    </div>

    <div class="card max-w-2xl">
        <div class="card-body">
            <form action="/coach/edit" method="POST">
                <input type="hidden" name="csrf_token" value="<?= \App\Helpers\Session::generateCsrfToken() ?>">

                <div class="form-group">
                    <label class="form-label" for="phone">Phone</label>
                    <input class="form-input" type="tel" id="phone" name="phone" value="<?= htmlspecialchars($coach['phone'] ?? '') ?>" required>
                </div>

                <div class="form-group">
                    <label class="form-label" for="address">Address</label>
                    <textarea class="form-input" id="address" name="address" rows="2"><?= htmlspecialchars($coach['address'] ?? '') ?></textarea>
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

                <div class="flex gap-4 mt-6">
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                    <a href="/coach/profile" class="btn btn-ghost">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
