<div class="page-header flex justify-between items-center mb-4">
    <div class="header-content">
        <h1 class="text-2xl font-bold m-0">Players</h1>
        <p class="text-muted m-0 mt-1"><?= count($players) ?> registered player<?= count($players) !== 1 ? 's' : '' ?></p>
    </div>
    <div class="header-actions flex items-center gap-3">
        <div class="search-box relative">
            <i class="ph ph-magnifying-glass absolute text-muted" style="left: 12px; top: 50%; transform: translateY(-50%);"></i>
            <input type="text" class="form-control pl-5 rounded-pill" placeholder="Search players..." id="playerSearch" oninput="filterPlayers(this.value)">
        </div>
        <a href="/admin/players/create" class="btn btn-primary rounded-pill px-4 shadow-sm"><i class="ph ph-plus mr-2"></i> Add Player</a>
        <button class="btn btn-outline-primary shadow-sm"><i class="ph ph-download-simple mr-2"></i> Export CSV</button>
    </div>
</div>

<div class="card shadow-sm border-0 rounded-lg overflow-hidden">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-striped table-hover mb-0 align-middle">
                <thead class="bg-light text-uppercase text-muted text-sm font-medium">
                    <tr>
                        <th class="border-top-0 py-3">Player</th>
                        <th class="border-top-0 py-3">Team</th>
                        <th class="border-top-0 py-3">Position</th>
                        <th class="border-top-0 py-3">Status</th>
                        <th class="border-top-0 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody id="playersTableBody">
                    <?php if (!empty($players)): ?>
                        <?php foreach ($players as $player): ?>
                            <tr>
                                <td class="py-3">
                                    <div class="flex items-center">
                                        <div class="avatar avatar-sm mr-3 overflow-hidden" style="width: 40px; height: 40px;">
                                            <?php if (!empty($player['avatar'])): ?>
                                                <img src="/public/uploads/avatars/<?= htmlspecialchars($player['avatar']) ?>" alt="Avatar" class="avatar-img" loading="lazy">
                                            <?php else: ?>
                                                <div class="avatar-initials flex items-center justify-center h-full bg-primary text-white font-bold">
                                                    <?= strtoupper(substr($player['first_name'] ?? 'P', 0, 1)) ?><?= strtoupper(substr($player['last_name'] ?? '', 0, 1)) ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <div>
                                            <strong class="text-dark d-block"><?= htmlspecialchars(($player['first_name'] ?? '') . ' ' . ($player['last_name'] ?? '')) ?></strong>
                                            <span class="text-muted text-xs"><?= htmlspecialchars($player['email'] ?? '') ?></span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <?php if (!empty($player['team_name'])): ?>
                                        <span class="font-medium text-dark"><?= htmlspecialchars($player['team_name']) ?></span>
                                    <?php else: ?>
                                        <span class="text-muted italic">Unassigned</span>
                                    <?php endif; ?>
                                </td>
                                <td><?= htmlspecialchars($player['position'] ?? 'N/A') ?></td>
                                <td>
                                    <?php
                                    $status = $player['registration_status'] ?? 'pending';
                                    $statusMap = [
                                        'pending' => ['badge-warning', 'Pending'],
                                        'under_review' => ['badge-info', 'Under Review'],
                                        'approved' => ['badge-success', 'Approved'],
                                        'rejected' => ['badge-danger', 'Rejected']
                                    ];
                                    [$badgeClass, $label] = $statusMap[$status] ?? ['badge-warning', 'Pending'];
                                    ?>
                                    <span class="badge <?= $badgeClass ?> rounded-pill px-3 py-1"><?= $label ?></span>
                                </td>
                                <td class="text-right">
                                    <a href="/admin/players/<?= $player['id'] ?>" class="btn btn-sm btn-light text-primary hover-bg-primary hover-text-white transition rounded-pill px-3">View Details</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center py-6 text-muted">
                                <i class="ph ph-users text-3xl mb-2 block"></i>
                                No players found.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <?php if (isset($totalPages) && $totalPages > 1): ?>
        <div class="border-top border-light px-4 py-3 flex justify-between items-center">
            <small class="text-muted">Page <?= $currentPage ?> of <?= $totalPages ?></small>
            <div class="flex gap-2">
                <?php if ($currentPage > 1): ?>
                    <a href="?page=<?= $currentPage - 1 ?>" class="btn btn-sm btn-light rounded-pill px-3"><i class="ph ph-caret-left mr-1"></i> Previous</a>
                <?php endif; ?>
                <?php if ($currentPage < $totalPages): ?>
                    <a href="?page=<?= $currentPage + 1 ?>" class="btn btn-sm btn-light rounded-pill px-3">Next <i class="ph ph-caret-right ml-1"></i></a>
                <?php endif; ?>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>

<style>
.avatar-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.avatar-initials {
    font-size: 0.75rem;
    border-radius: var(--radius-full);
}

.italic {
    font-style: italic;
}

.pl-5 {
    padding-left: 2.5rem;
}

.table-responsive {
    overflow-x: auto;
}

.py-6 {
    padding-top: 2rem;
    padding-bottom: 2rem;
}

.text-3xl {
    font-size: 1.875rem;
}
</style>
<script>
function filterPlayers(query) {
    const rows = document.querySelectorAll('#playersTableBody tr');
    const q = query.toLowerCase().trim();
    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        row.style.display = !q || text.includes(q) ? '' : 'none';
    });
}
</script>
