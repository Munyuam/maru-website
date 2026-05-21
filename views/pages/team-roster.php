<div class="container py-8">
    <div class="page-header flex justify-between items-center mb-6">
        <div>
            <h1 class="page-title text-2xl font-bold">Team Roster</h1>
            <?php if (isset($team)): ?>
                <p class="page-subtitle text-muted"><?= htmlspecialchars($team['name'] ?? '') ?> - <?= htmlspecialchars($team['division'] ?? '') ?> Division</p>
            <?php endif; ?>
        </div>
        <div class="page-actions">
            <a href="/coach/profile" class="btn btn-outline">Back to Profile</a>
        </div>
    </div>

    <div class="card overflow-hidden">
        <div class="table-responsive">
            <table class="table table-striped w-full text-left border-collapse">
                <thead class="bg-light text-muted">
                    <tr>
                        <th class="p-4 border-b">Player Name</th>
                        <th class="p-4 border-b">Position</th>
                        <th class="p-4 border-b">Experience</th>
                        <th class="p-4 border-b">Status</th>
                        <th class="p-4 border-b text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (isset($players) && is_array($players) && count($players) > 0): ?>
                        <?php foreach ($players as $player): ?>
                            <tr class="hover:bg-gray-50 border-b">
                                <td class="p-4">
                                    <div class="font-medium"><?= htmlspecialchars(($player['first_name'] ?? '') . ' ' . ($player['last_name'] ?? '')) ?></div>
                                </td>
                                <td class="p-4"><?= htmlspecialchars($player['preferred_position'] ?? 'Unassigned') ?></td>
                                <td class="p-4"><?= htmlspecialchars($player['years_played'] ?? '0') ?> years</td>
                                <td class="p-4">
                                    <?php 
                                        $statusClass = 'badge-secondary';
                                        $statusText = $player['status'] ?? 'pending';
                                        if ($statusText === 'active' || $statusText === 'approved') {
                                            $statusClass = 'badge-success';
                                        } elseif ($statusText === 'rejected' || $statusText === 'inactive') {
                                            $statusClass = 'badge-danger';
                                        }
                                    ?>
                                    <span class="badge <?= $statusClass ?> px-2 py-1 rounded text-xs uppercase font-bold text-white bg-opacity-90" style="background-color: <?= $statusClass === 'badge-success' ? '#10b981' : ($statusClass === 'badge-danger' ? '#ef4444' : '#6b7280') ?>;">
                                        <?= htmlspecialchars($statusText) ?>
                                    </span>
                                </td>
                                <td class="p-4 text-right">
                                    <a href="/player/<?= htmlspecialchars($player['id'] ?? '') ?>" class="btn btn-sm btn-outline-primary">View</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="p-8 text-center text-muted">
                                <div class="empty-state">
                                    <i class="icon-users text-4xl mb-2 block"></i>
                                    <p>No players assigned to this team yet.</p>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
