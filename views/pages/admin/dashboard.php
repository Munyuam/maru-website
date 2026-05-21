<div class="page-header mb-4">
    <div class="header-content">
        <h1 class="text-2xl font-bold">Admin Dashboard</h1>
        <p class="text-muted">Overview of the MARU Registration System</p>
    </div>
</div>

<div class="stats-grid grid grid-4 gap-4 mb-4">
    <div class="card stat-card shadow-sm border-0">
        <div class="card-body flex items-center justify-between p-4">
            <div>
                <p class="stat-label text-muted mb-1 font-medium text-sm uppercase">Total Players</p>
                <h3 class="stat-value text-3xl font-bold mb-0"><?= number_format($totalPlayers) ?></h3>
            </div>
            <div class="stat-icon text-primary bg-primary-light rounded-circle p-3 flex items-center justify-center" style="width: 48px; height: 48px;">
                <i class="ph ph-users text-xl"></i>
            </div>
        </div>
    </div>
    <div class="card stat-card shadow-sm border-0">
        <div class="card-body flex items-center justify-between p-4">
            <div>
                <p class="stat-label text-muted mb-1 font-medium text-sm uppercase">Pending Approvals</p>
                <h3 class="stat-value text-3xl font-bold mb-0"><?= number_format($pendingRegistrations) ?></h3>
            </div>
            <div class="stat-icon text-warning bg-warning-light rounded-circle p-3 flex items-center justify-center" style="width: 48px; height: 48px;">
                <i class="ph ph-clock text-xl"></i>
            </div>
        </div>
    </div>
    <div class="card stat-card shadow-sm border-0">
        <div class="card-body flex items-center justify-between p-4">
            <div>
                <p class="stat-label text-muted mb-1 font-medium text-sm uppercase">Total Teams</p>
                <h3 class="stat-value text-3xl font-bold mb-0"><?= number_format($totalTeams) ?></h3>
            </div>
            <div class="stat-icon text-success bg-success-light rounded-circle p-3 flex items-center justify-center" style="width: 48px; height: 48px;">
                <i class="ph ph-shield-check text-xl"></i>
            </div>
        </div>
    </div>
    <div class="card stat-card shadow-sm border-0">
        <div class="card-body flex items-center justify-between p-4">
            <div>
                <p class="stat-label text-muted mb-1 font-medium text-sm uppercase">Active Coaches</p>
                <h3 class="stat-value text-3xl font-bold mb-0"><?= number_format($totalCoaches) ?></h3>
            </div>
            <div class="stat-icon text-info bg-info-light rounded-circle p-3 flex items-center justify-center" style="width: 48px; height: 48px;">
                <i class="ph ph-user text-xl"></i>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-2 gap-4">
    <div class="card shadow-sm border-0">
        <div class="card-header border-bottom flex justify-between items-center bg-white py-3">
            <h2 class="text-lg font-bold m-0">Recent Registrations</h2>
            <a href="/admin/players" class="btn btn-sm btn-outline-secondary">View All</a>
        </div>
        <div class="card-body p-0">
            <?php if (!empty($recentPlayers)): ?>
                <div class="activity-list">
                    <?php foreach ($recentPlayers as $player): ?>
                        <div class="activity-item p-3 border-bottom flex items-start hover-bg-light transition">
                            <div class="avatar avatar-sm bg-primary text-white rounded-circle mr-3 flex-shrink-0 flex items-center justify-center overflow-hidden" style="width: 36px; height: 36px;">
                                <?php if (!empty($player['avatar'])): ?>
                                    <img src="/public/uploads/avatars/<?= htmlspecialchars($player['avatar']) ?>" alt="Avatar" class="avatar-img" loading="lazy">
                                <?php else: ?>
                                    <?= strtoupper(substr($player['first_name'] ?? 'P', 0, 1)) ?><?= strtoupper(substr($player['last_name'] ?? '', 0, 1)) ?>
                                <?php endif; ?>
                            </div>
                            <div class="flex-1">
                                <div class="flex justify-between items-center mb-1">
                                    <strong class="text-dark"><?= htmlspecialchars(($player['first_name'] ?? '') . ' ' . ($player['last_name'] ?? '')) ?></strong>
                                    <small class="text-muted"><?= date('M j, Y', strtotime($player['registered_at'] ?? 'now')) ?></small>
                                </div>
                                <p class="text-sm text-muted m-0">Registered as a Player - <span class="badge <?= $player['registration_status'] === 'approved' ? 'badge-success' : ($player['registration_status'] === 'rejected' ? 'badge-danger' : 'badge-warning') ?>"><?= ucfirst(str_replace('_', ' ', $player['registration_status'] ?? 'pending')) ?></span></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="p-4 text-center text-muted">
                    <i class="ph ph-users text-2xl mb-2 block"></i>
                    No registrations yet.
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-header border-bottom flex justify-between items-center bg-white py-3">
            <h2 class="text-lg font-bold m-0">Pending Actions</h2>
        </div>
        <div class="card-body p-0">
            <?php if (!empty($pendingItems)): ?>
                <div class="table-responsive">
                    <table class="table table-hover m-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="border-top-0">Action</th>
                                <th class="border-top-0">User</th>
                                <th class="border-top-0">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($pendingItems as $item): ?>
                                <tr>
                                    <td class="font-medium text-dark"><i class="ph <?= $item['icon'] ?> mr-2" style="color: var(--color-primary);"></i> <?= htmlspecialchars($item['action']) ?></td>
                                    <td><?= htmlspecialchars($item['user']) ?></td>
                                    <td><span class="badge <?= $item['badgeClass'] ?> rounded-pill px-2 py-1"><?= htmlspecialchars($item['status']) ?></span></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="p-4 text-center text-muted">
                    <i class="ph ph-check-circle text-2xl mb-2 block" style="color: var(--color-success);"></i>
                    No pending actions. All caught up!
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
