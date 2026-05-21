<div class="page-header flex justify-between items-center mb-4">
    <div class="header-content">
        <h1 class="text-2xl font-bold m-0">Coaches</h1>
        <p class="text-muted m-0 mt-1"><?= count($coaches) ?> coach<?= count($coaches) !== 1 ? 'es' : '' ?></p>
    </div>
    <div class="header-actions">
        <a href="/admin/coaches/create" class="btn btn-primary rounded-pill px-4 shadow-sm"><i class="ph ph-plus mr-2"></i> Add Coach</a>
    </div>
</div>

<div class="card shadow-sm border-0 rounded-lg overflow-hidden">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle">
                <thead class="bg-light text-uppercase text-muted text-sm font-medium">
                    <tr>
                        <th class="border-top-0 py-3 pl-4">Coach Info</th>
                        <th class="border-top-0 py-3">Assigned Team</th>
                        <th class="border-top-0 py-3">Contact</th>
                        <th class="border-top-0 py-3">Status</th>
                        <th class="border-top-0 py-3 text-right pr-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($coaches)): ?>
                        <?php foreach ($coaches as $coach): ?>
                            <tr class="hover-bg-light transition">
                                <td class="py-3 pl-4">
                                    <div class="flex items-center">
                                        <div class="avatar-sm mr-3 overflow-hidden shadow-sm" style="width: 40px; height: 40px; border-radius: var(--radius-full);">
                                            <?php if (!empty($coach['avatar'])): ?>
                                                <img src="/public/uploads/avatars/<?= htmlspecialchars($coach['avatar']) ?>" alt="Avatar" class="avatar-img" style="width: 100%; height: 100%; object-fit: cover;" loading="lazy">
                                            <?php else: ?>
                                                <div class="flex items-center justify-center h-full bg-primary text-white font-bold text-xs">
                                                    <?= strtoupper(substr($coach['first_name'] ?? 'C', 0, 1)) ?><?= strtoupper(substr($coach['last_name'] ?? '', 0, 1)) ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <div>
                                            <strong class="text-dark d-block"><?= htmlspecialchars(($coach['first_name'] ?? '') . ' ' . ($coach['last_name'] ?? '')) ?></strong>
                                            <span class="text-muted text-xs"><?= htmlspecialchars($coach['email'] ?? '') ?></span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <?php if (!empty($coach['team_name'])): ?>
                                        <div class="flex items-center">
                                            <span class="font-medium text-dark"><?= htmlspecialchars($coach['team_name']) ?></span>
                                        </div>
                                    <?php else: ?>
                                        <span class="text-muted italic"><i class="ph ph-warning-circle mr-1"></i> Unassigned</span>
                                    <?php endif; ?>
                                </td>
                                <td><a href="mailto:<?= htmlspecialchars($coach['email'] ?? '') ?>" class="text-muted hover-text-primary transition"><i class="ph ph-envelope mr-1"></i> <?= htmlspecialchars($coach['email'] ?? 'N/A') ?></a></td>
                                <td>
                                    <?php
                                    $status = $coach['registration_status'] ?? 'pending';
                                    $statusMap = [
                                        'pending' => ['badge-warning', 'Pending Review'],
                                        'under_review' => ['badge-info', 'Under Review'],
                                        'approved' => ['badge-success', 'Active'],
                                        'rejected' => ['badge-danger', 'Inactive']
                                    ];
                                    [$badgeClass, $label] = $statusMap[$status] ?? ['badge-warning', 'Pending'];
                                    ?>
                                    <span class="badge <?= $badgeClass ?> rounded-pill px-3 py-1"><?= $label ?></span>
                                </td>
                                <td class="text-right pr-4">
                                    <a href="/admin/coaches/<?= $coach['id'] ?>" class="btn btn-sm btn-light text-primary hover-bg-primary hover-text-white transition rounded-pill px-3">Details</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center py-6 text-muted">
                                <i class="ph ph-chalkboard-teacher text-3xl mb-2 block"></i>
                                No coaches found.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
.avatar-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.italic {
    font-style: italic;
}

.py-6 {
    padding-top: 2rem;
    padding-bottom: 2rem;
}

.text-3xl {
    font-size: 1.875rem;
}

.hover-bg-light:hover {
    background-color: var(--color-bg-tertiary);
}

.transition {
    transition: background-color var(--transition-fast);
}
</style>
