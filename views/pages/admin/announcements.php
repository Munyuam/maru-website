<div class="page-header flex justify-between items-center mb-4">
    <div class="header-content">
        <h1 class="text-2xl font-bold m-0">Announcements</h1>
        <p class="text-muted m-0 mt-1">Publish and manage system-wide announcements</p>
    </div>
    <div class="header-actions">
        <a  href="<?= url('/admin/announcements/create') ?>"  class="btn btn-primary rounded-pill px-4 shadow-sm">
            <i class="ph ph-plus mr-2"></i> New Announcement
        </a>
    </div>
</div>

<div class="card shadow-sm border-0 rounded-lg overflow-hidden">
    <div class="card-body p-0">
        <?php if (!empty($announcements)): ?>
            <?php foreach ($announcements as $announcement): ?>
                <div class="p-4 border-bottom <?= $announcement['type'] === 'warning' ? 'bg-warning-light' : '' ?>">
                    <div class="flex items-start gap-3">
                        <div class="flex-shrink-0 mt-1">
                            <?php if ($announcement['type'] === 'warning'): ?>
                                <i class="ph ph-warning-circle text-warning text-xl"></i>
                            <?php elseif ($announcement['type'] === 'success'): ?>
                                <i class="ph ph-check-circle text-success text-xl"></i>
                            <?php else: ?>
                                <i class="ph ph-info text-primary text-xl"></i>
                            <?php endif; ?>
                        </div>
                        <div class="flex-1">
                            <div class="flex justify-between items-start mb-1">
                                <h3 class="text-base font-bold m-0"><?= htmlspecialchars($announcement['title']) ?></h3>
                                <small class="text-muted"><?= htmlspecialchars(date('M j, Y g:i A', strtotime($announcement['created_at']))) ?></small>
                            </div>
                            <p class="text-muted text-sm mb-2"><?= nl2br(htmlspecialchars($announcement['message'])) ?></p>
                            <small class="text-xs text-muted">Posted by <?= htmlspecialchars(($announcement['first_name'] ?? '') . ' ' . ($announcement['last_name'] ?? 'System')) ?>
                                <?php if ($announcement['target_type'] === 'team' && !empty($announcement['team_name'])): ?>
                                    &middot; Team: <?= htmlspecialchars($announcement['team_name']) ?>
                                <?php endif; ?>
                            </small>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="text-center py-5 text-muted">
                <i class="ph ph-megaphone text-4xl mb-3 d-block"></i>
                <p class="m-0">No announcements yet.</p>
                <a  href="<?= url('/admin/announcements/create') ?>"  class="btn btn-primary btn-sm mt-3 rounded-pill">Create First Announcement</a>
            </div>
        <?php endif; ?>
    </div>
</div>
