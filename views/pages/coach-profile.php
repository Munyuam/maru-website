<div class="container py-8">
    <div class="page-header mb-6">
        <h1 class="page-title">Coach Profile</h1>
        <div class="page-actions">
            <a href="/coach/edit" class="btn btn-outline">Edit Profile</a>
        </div>
    </div>

    <div class="profile-layout grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="profile-sidebar col-span-1">
            <div class="card card-profile text-center p-6">
                <div class="profile-avatar mb-4">
                    <div class="avatar-placeholder bg-primary text-white rounded-circle flex items-center justify-center mx-auto" style="width: 120px; height: 120px; font-size: 3rem;">
                        <?= htmlspecialchars(substr($coach['first_name'] ?? 'C', 0, 1) . substr($coach['last_name'] ?? '', 0, 1)) ?>
                    </div>
                </div>
                <h2 class="profile-name text-xl font-bold mb-1">
                    <?= htmlspecialchars(($coach['first_name'] ?? '') . ' ' . ($coach['last_name'] ?? '')) ?>
                </h2>
                <p class="profile-role text-muted mb-4">Head Coach</p>
                <div class="profile-contact text-left bg-light p-4 rounded">
                    <div class="contact-item mb-2">
                        <i class="icon-mail mr-2"></i> <?= htmlspecialchars($coach['email'] ?? '') ?>
                    </div>
                    <?php if (isset($coach['date_of_birth'])): ?>
                    <div class="contact-item">
                        <i class="icon-calendar mr-2"></i> Born: <?= htmlspecialchars(date('M d, Y', strtotime($coach['date_of_birth']))) ?>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="profile-content col-span-1 md:col-span-2">
            <div class="card mb-6 p-6">
                <h3 class="card-title text-lg font-bold mb-4 border-b pb-2">Coaching Credentials</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="info-group">
                        <label class="text-sm text-muted block">Qualification</label>
                        <div class="font-medium"><?= htmlspecialchars($coach['qualification'] ?? 'N/A') ?></div>
                    </div>
                    <div class="info-group">
                        <label class="text-sm text-muted block">Experience</label>
                        <div class="font-medium"><?= htmlspecialchars($coach['years_experience'] ?? '0') ?> Years</div>
                    </div>
                    <div class="info-group col-span-1 sm:col-span-2">
                        <label class="text-sm text-muted block">Specialty</label>
                        <div class="font-medium"><?= htmlspecialchars($coach['coaching_specialty'] ?? 'General') ?></div>
                    </div>
                </div>
            </div>

            <div class="card p-6">
                <h3 class="card-title text-lg font-bold mb-4 border-b pb-2">Current Team</h3>
                <?php if (!empty($team)): ?>
                    <div class="team-info flex items-center justify-between bg-light p-4 rounded">
                        <div>
                            <h4 class="font-bold text-lg"><?= htmlspecialchars($team['name'] ?? 'Unnamed Team') ?></h4>
                            <p class="text-muted text-sm"><?= htmlspecialchars($team['division'] ?? '') ?> Division</p>
                        </div>
                        <a href="/coach/roster" class="btn btn-primary btn-sm">View Roster</a>
                    </div>
                <?php else: ?>
                    <div class="alert alert-warning">
                        You are not currently assigned to any team.
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
