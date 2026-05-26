<?php
$teamColors = ['bg-primary', 'bg-secondary', 'bg-warning', 'bg-info', 'bg-danger'];
$teamIcons = ['ph-fire', 'ph-paw-print', 'ph-feather', 'ph-lightning', 'ph-shield'];
$colorIndex = ($team['id'] ?? 0) % count($teamColors);
$colorClass = $teamColors[$colorIndex];
$iconClass = $teamIcons[$colorIndex];
$playerCount = count($roster ?? []);
$maxPlayers = $team['max_players'] ?? 30;
$percentFull = $maxPlayers > 0 ? round(($playerCount / $maxPlayers) * 100) : 0;
?>

<div class="page-header mb-5">
    <div class="flex justify-between items-center">
        <div class="flex items-center gap-4">
            <a  href="<?= url('/admin/teams') ?>"  class="btn btn-sm btn-light text-muted hover-bg-light rounded-circle shadow-sm flex items-center justify-center p-0" style="width: 36px; height: 36px;"><i class="ph ph-arrow-left"></i></a>
            <div>
                <h1 class="text-3xl font-bold m-0 flex items-center">
                    <?= htmlspecialchars($team['name'] ?? 'Team') ?>
                    <?php if (!empty($team['division'])): ?>
                        <span class="badge bg-light text-dark border ml-3 rounded-pill text-sm px-3 py-1 font-medium align-middle"><?= htmlspecialchars($team['division']) ?></span>
                    <?php endif; ?>
                </h1>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-4 gap-4 mb-5">
    <div class="card stat-card shadow-sm border-0 rounded-xl">
        <div class="card-body p-4 flex items-center">
            <div class="stat-icon text-primary bg-primary-light rounded-lg p-3 mr-4 flex items-center justify-center" style="width: 56px; height: 56px;"><i class="ph ph-users text-2xl"></i></div>
            <div>
                <p class="stat-label mb-1 text-muted text-sm font-bold uppercase tracking-wider">Roster Fill</p>
                <h3 class="stat-value mb-0 text-2xl font-bold text-dark"><?= $playerCount ?> <span class="text-muted text-sm font-normal">/ <?= $maxPlayers ?> max</span></h3>
            </div>
        </div>
    </div>
    <div class="card stat-card shadow-sm border-0 rounded-xl">
        <div class="card-body p-4 flex items-center">
            <div class="stat-icon text-success bg-success-light rounded-lg p-3 mr-4 flex items-center justify-center" style="width: 56px; height: 56px;"><i class="ph ph-user text-2xl"></i></div>
            <div>
                <p class="stat-label mb-1 text-muted text-sm font-bold uppercase tracking-wider">Head Coach</p>
                <?php
                $coachName = trim(($team['coach_first_name'] ?? '') . ' ' . ($team['coach_last_name'] ?? ''));
                ?>
                <h3 class="stat-value mb-0 text-xl font-bold text-dark"><?= !empty($coachName) ? htmlspecialchars($coachName) : 'Unassigned' ?></h3>
            </div>
        </div>
    </div>
    <div class="card stat-card shadow-sm border-0 rounded-xl">
        <div class="card-body p-4 flex items-center">
            <div class="stat-icon text-warning bg-warning-light rounded-lg p-3 mr-4 flex items-center justify-center" style="width: 56px; height: 56px;"><i class="ph ph-chart-bar text-2xl"></i></div>
            <div>
                <p class="stat-label mb-1 text-muted text-sm font-bold uppercase tracking-wider">Capacity</p>
                <h3 class="stat-value mb-0 text-xl font-bold text-dark"><?= $percentFull ?>% <span class="text-muted text-sm font-normal">Full</span></h3>
            </div>
        </div>
    </div>
    <div class="card stat-card shadow-sm border-0 rounded-xl <?= $team['is_active'] ? 'bg-primary text-white' : 'bg-light' ?>">
        <div class="card-body p-4 flex flex-col justify-center items-center text-center">
            <p class="stat-label mb-1 <?= $team['is_active'] ? 'text-white opacity-80' : 'text-muted' ?> text-sm font-bold uppercase tracking-wider">Team Status</p>
            <h3 class="stat-value mb-0 text-2xl font-bold"><?= $team['is_active'] ? 'Active' : 'Inactive' ?></h3>
        </div>
    </div>
</div>

<div class="card shadow-sm border-0 rounded-xl overflow-hidden">
    <div class="card-header bg-white border-bottom py-4 px-5 flex justify-between items-center">
        <h2 class="text-xl font-bold m-0"><i class="ph ph-clipboard-text text-primary mr-2"></i> Official Roster</h2>
    </div>
    <div class="card-body p-0">
        <?php if (!empty($roster)): ?>
        <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle">
                <thead class="bg-light text-uppercase text-muted text-xs font-bold tracking-wider">
                    <tr>
                        <th class="border-top-0 py-3 pl-5 w-16 text-center">#</th>
                        <th class="border-top-0 py-3">Player Name</th>
                        <th class="border-top-0 py-3">Position</th>
                        <th class="border-top-0 py-3 text-center">Gender</th>
                        <th class="border-top-0 py-3 text-center">Status</th>
                        <th class="border-top-0 py-3 text-right pr-5">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($roster as $index => $player): ?>
                    <tr class="hover-bg-light transition group">
                        <td class="py-4 pl-5 text-center"><strong class="text-dark text-lg font-bold"><?= $index + 1 ?></strong></td>
                        <td>
                            <div class="flex items-center">
                                <div class="avatar avatar-sm <?= $colorClass ?> text-white rounded-circle mr-3 flex items-center justify-center shadow-sm font-bold overflow-hidden" style="width:36px;height:36px;">
                                    <?php if (!empty($player['avatar'])): ?>
                                        <img  src="<?= url('/public/uploads/avatars/' . htmlspecialchars($player['avatar'])) ?>"  alt="Avatar" class="avatar-img" loading="lazy">
                                    <?php else: ?>
                                        <?= strtoupper(substr($player['first_name'] ?? 'P', 0, 1)) ?><?= strtoupper(substr($player['last_name'] ?? '', 0, 1)) ?>
                                    <?php endif; ?>
                                </div>
                                <div>
                                    <a  href="<?= url('/admin/players/' . $player['id']) ?>"  class="text-dark font-bold hover-text-primary transition d-block"><?= htmlspecialchars(($player['first_name'] ?? '') . ' ' . ($player['last_name'] ?? '')) ?></a>
                                    <span class="text-xs text-muted"><?= htmlspecialchars($player['email'] ?? '') ?></span>
                                </div>
                            </div>
                        </td>
                        <td><span class="font-medium text-dark"><?= htmlspecialchars($player['position'] ?? 'N/A') ?></span></td>
                        <td class="text-center text-muted font-medium"><?= htmlspecialchars(ucfirst($player['gender'] ?? 'N/A')) ?></td>
                        <td class="text-center">
                            <?php
                            $status = $player['registration_status'] ?? 'pending';
                            $statusMap = [
                                'pending' => ['badge-warning', 'Pending'],
                                'under_review' => ['badge-info', 'Under Review'],
                                'approved' => ['badge-success', 'Active'],
                                'rejected' => ['badge-danger', 'Inactive']
                            ];
                            [$badgeClass, $label] = $statusMap[$status] ?? ['badge-warning', 'Pending'];
                            ?>
                            <span class="badge <?= $badgeClass ?> rounded-pill px-3 py-1"><?= $label ?></span>
                        </td>
                        <td class="text-right pr-5">
                            <a  href="<?= url('/admin/players/' . $player['id']) ?>"  class="btn btn-sm btn-light text-primary hover-bg-primary hover-text-white transition rounded-pill px-3">View</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php else: ?>
        <div class="text-center py-6 text-muted">
            <i class="ph ph-users text-4xl mb-3 block"></i>
            <p class="m-0">No players on this team yet.</p>
        </div>
        <?php endif; ?>
    </div>
</div>
