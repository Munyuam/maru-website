<div class="container py-8">
    <div class="page-header mb-6">
        <a  href="<?= url('/coach/team') ?>"  class="btn btn-ghost">
            <i class="ph ph-arrow-left mr-2"></i> Back to Team Roster
        </a>
    </div>

    <div class="grid grid-3 gap-6">
        <div class="col-span-1">
            <div class="card text-center">
                <div class="card-body">
                    <div class="flex-center mx-auto mb-4" style="width: 96px; height: 96px; border-radius: var(--radius-full); background: var(--color-primary); color: white; font-size: 2.5rem; font-weight: 700; overflow: hidden;">
                        <?php if (!empty($player['avatar'])): ?>
                            <img  src="<?= url('/public/uploads/avatars/' . htmlspecialchars($player['avatar'])) ?>"  alt="Avatar" style="width: 100%; height: 100%; object-fit: cover;">
                        <?php else: ?>
                            <?= strtoupper(substr($player['first_name'] ?? 'P', 0, 1)) ?><?= strtoupper(substr($player['last_name'] ?? '', 0, 1)) ?>
                        <?php endif; ?>
                    </div>
                    <h2 class="heading-3 mb-1"><?= htmlspecialchars($player['first_name'] ?? '') ?> <?= htmlspecialchars($player['last_name'] ?? '') ?></h2>
                    <p class="text-muted text-sm mb-4"><?= htmlspecialchars($player['email'] ?? '') ?></p>
                    <span class="badge <?= ($player['registration_status'] ?? '') === 'approved' ? 'badge-success' : (($player['registration_status'] ?? '') === 'rejected' ? 'badge-error' : 'badge-warning') ?>">
                        <?= htmlspecialchars(ucfirst($player['registration_status'] ?? 'pending')) ?>
                    </span>
                </div>
            </div>
        </div>

        <div class="col-span-2">
            <div class="card mb-6">
                <div class="card-header">
                    <h3 class="heading-4 m-0">Player Information</h3>
                </div>
                <div class="card-body">
                    <div class="grid grid-2 gap-4">
                        <div>
                            <span class="text-xs text-muted block mb-1">Position</span>
                            <span class="font-medium"><?= htmlspecialchars(ucfirst($player['position'] ?? 'N/A')) ?></span>
                        </div>
                        <div>
                            <span class="text-xs text-muted block mb-1">Date of Birth</span>
                            <span class="font-medium"><?= htmlspecialchars($player['date_of_birth'] ?? 'N/A') ?></span>
                        </div>
                        <div>
                            <span class="text-xs text-muted block mb-1">Gender</span>
                            <span class="font-medium"><?= htmlspecialchars(ucfirst($player['gender'] ?? 'N/A')) ?></span>
                        </div>
                        <div>
                            <span class="text-xs text-muted block mb-1">Nationality</span>
                            <span class="font-medium"><?= htmlspecialchars($player['nationality'] ?? 'N/A') ?></span>
                        </div>
                        <div>
                            <span class="text-xs text-muted block mb-1">Phone</span>
                            <span class="font-medium"><?= htmlspecialchars($player['phone'] ?? 'N/A') ?></span>
                        </div>
                        <div>
                            <span class="text-xs text-muted block mb-1">Experience</span>
                            <span class="font-medium"><?= htmlspecialchars((string)($player['playing_experience'] ?? '0')) ?> years</span>
                        </div>
                    </div>
                </div>
            </div>

            <?php if (!empty($player['previous_clubs']) || !empty($player['emergency_contact_name'])): ?>
            <div class="card">
                <div class="card-header">
                    <h3 class="heading-4 m-0">Additional Info</h3>
                </div>
                <div class="card-body">
                    <div class="grid grid-2 gap-4">
                        <?php if (!empty($player['previous_clubs'])): ?>
                        <div>
                            <span class="text-xs text-muted block mb-1">Previous Clubs</span>
                            <span class="font-medium"><?= htmlspecialchars($player['previous_clubs']) ?></span>
                        </div>
                        <?php endif; ?>
                        <?php if (!empty($player['emergency_contact_name'])): ?>
                        <div>
                            <span class="text-xs text-muted block mb-1">Emergency Contact</span>
                            <span class="font-medium"><?= htmlspecialchars($player['emergency_contact_name']) ?> (<?= htmlspecialchars($player['emergency_contact_phone'] ?? '') ?>)</span>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>
