<?php
$teamColors = ['bg-primary', 'bg-secondary', 'bg-warning', 'bg-info', 'bg-danger'];
$teamIcons = ['ph-fire', 'ph-paw-print', 'ph-feather', 'ph-lightning', 'ph-shield'];
?>

<div class="page-header flex justify-between items-center mb-5">
    <div class="header-content">
        <h1 class="text-3xl font-bold m-0">Teams</h1>
        <p class="text-muted m-0 mt-1"><?= count($teams) ?> team<?= count($teams) !== 1 ? 's' : '' ?></p>
    </div>
    <div class="header-actions flex gap-3">
        <div class="search-box relative">
            <i class="ph ph-magnifying-glass absolute text-muted" style="left: 12px; top: 50%; transform: translateY(-50%);"></i>
            <input type="text" class="form-control pl-5 rounded-pill bg-white shadow-sm border-0" placeholder="Search teams...">
        </div>
        <a  href="<?= url('/admin/teams/create') ?>"  class="btn btn-primary rounded-pill px-4 shadow-sm flex items-center"><i class="ph ph-plus mr-2"></i> Add Team</a>
    </div>
</div>

<?php if (!empty($teams)): ?>
    <div class="grid grid-3 gap-5">
        <?php foreach ($teams as $index => $team): ?>
            <?php
            $colorClass = $teamColors[$index % count($teamColors)];
            $iconClass = $teamIcons[$index % count($teamIcons)];
            $playerCount = $team['player_count'] ?? 0;
            $maxPlayers = $team['max_players'] ?? 30;
            $percentFull = $maxPlayers > 0 ? round(($playerCount / $maxPlayers) * 100) : 0;
            $barColor = $percentFull >= 100 ? 'bg-danger' : ($percentFull >= 75 ? 'bg-success' : 'bg-warning');
            ?>
            <div class="card team-card shadow-sm border-0 rounded-xl overflow-hidden hover-shadow-lg transition transform hover-translate-y-1 relative group cursor-pointer" onclick="window.location.href='/admin/teams/<?= $team['id'] ?>'">
                <div class="h-2 <?= $colorClass ?> w-full absolute top-0 left-0"></div>
                <div class="card-header border-0 bg-white pt-4 pb-0 flex justify-between items-start">
                    <div class="avatar avatar-lg <?= $colorClass ?>-light text-<?= str_replace('bg-', '', $colorClass) ?> rounded-lg flex items-center justify-center text-2xl font-bold shadow-sm" style="width:72px;height:72px;">
                        <i class="ph <?= $iconClass ?> text-3xl"></i>
                    </div>
                    <div class="dropdown">
                        <button class="btn btn-sm btn-icon text-muted hover-bg-light rounded-circle" onclick="event.stopPropagation();"><i class="ph ph-dots-three-vertical"></i></button>
                    </div>
                </div>
                <div class="card-body pt-4 pb-3">
                    <h3 class="text-2xl font-bold mb-1 text-dark"><?= htmlspecialchars($team['name'] ?? 'Team') ?></h3>
                    <?php if (!empty($team['division'])): ?>
                        <span class="badge bg-light text-dark border rounded-pill px-3 py-1 mb-4 font-medium"><?= htmlspecialchars($team['division']) ?></span>
                    <?php endif; ?>
                    
                    <div class="text-sm text-muted mb-4 space-y-2">
                        <?php 
                        $coachName = trim(($team['coach_first_name'] ?? '') . ' ' . ($team['coach_last_name'] ?? ''));
                        ?>
                        <?php if (!empty($coachName)): ?>
                            <div class="flex items-center">
                                <?php if (!empty($team['coach_avatar'])): ?>
                                    <div class="avatar-sm mr-2 overflow-hidden" style="width: 24px; height: 24px; border-radius: var(--radius-full);">
                                        <img  src="<?= url('/public/uploads/avatars/' . htmlspecialchars($team['coach_avatar'])) ?>"  alt="Coach" class="avatar-img" loading="lazy">
                                    </div>
                                <?php endif; ?>
                                <span class="font-medium text-dark"><?= htmlspecialchars($coachName) ?></span>
                            </div>
                        <?php else: ?>
                            <div class="flex items-center"><i class="ph ph-user w-6 text-center text-warning"></i> <span class="font-medium text-warning italic">Pending Assignment</span></div>
                        <?php endif; ?>
                        <div class="flex items-center justify-between">
                            <div><i class="ph ph-users w-6 text-center text-primary"></i> <strong class="text-dark"><?= $playerCount ?></strong> / <?= $maxPlayers ?> Players</div>
                            <span class="text-xs <?= $percentFull >= 100 ? 'text-danger' : 'text-warning' ?> font-bold"><?= $percentFull ?>% Full</span>
                        </div>
                    </div>
                    
                    <div class="progress rounded-pill bg-light" style="height: 8px;">
                        <div class="progress-bar <?= $barColor ?> rounded-pill" style="width: <?= $percentFull ?>%;"></div>
                    </div>
                </div>
                <div class="card-footer bg-white border-top border-light py-3 text-center group-hover-bg-light transition">
                    <span class="text-primary font-bold text-sm uppercase tracking-wider">View Roster <i class="ph ph-arrow-right ml-1 transform group-hover-translate-x-1 transition"></i></span>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php else: ?>
    <div class="card shadow-sm border-0 rounded-xl p-8 text-center">
        <i class="ph ph-trophy text-4xl text-muted mb-4 block"></i>
        <h3 class="text-xl font-bold mb-2">No Teams Yet</h3>
        <p class="text-muted mb-4">Create your first team to get started.</p>
        <a  href="<?= url('/admin/teams/create') ?>"  class="btn btn-primary"><i class="ph ph-plus mr-2"></i> Add Team</a>
    </div>
<?php endif; ?>

<style>
.hover-shadow-lg:hover {
    box-shadow: var(--shadow-lg);
}

.hover-translate-y-1:hover {
    transform: translateY(-4px);
}

.transform {
    transform: transition;
}

.group-hover-bg-light:hover {
    background-color: var(--color-bg-tertiary);
}

.group-hover-translate-x-1:hover {
    transform: translateX(4px);
}

.transition {
    transition: all var(--transition-base);
}

.space-y-2 > * + * {
    margin-top: 0.5rem;
}

.bg-light {
    background-color: var(--color-bg-tertiary);
}

.bg-primary-light { background-color: rgba(239, 68, 68, 0.1); }
.bg-secondary-light { background-color: rgba(16, 185, 129, 0.1); }
.bg-warning-light { background-color: rgba(234, 179, 8, 0.1); }
.bg-info-light { background-color: rgba(59, 130, 246, 0.1); }
.bg-danger-light { background-color: rgba(239, 68, 68, 0.1); }

.text-primary { color: var(--color-primary); }
.text-secondary { color: var(--color-secondary); }
.text-warning { color: var(--color-warning); }
.text-info { color: var(--color-info); }
.text-danger { color: var(--color-error); }

.bg-primary { background-color: var(--color-primary); }
.bg-secondary { background-color: var(--color-secondary); }
.bg-warning { background-color: var(--color-warning); }
.bg-info { background-color: var(--color-info); }
.bg-danger { background-color: var(--color-error); }

.progress-bar {
    transition: width var(--transition-base);
}

.pl-5 {
    padding-left: 2.5rem;
}

.text-4xl {
    font-size: 2.25rem;
}
</style>
