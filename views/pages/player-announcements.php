<div class="container py-8">
    <div class="page-header mb-6">
        <div class="header-content">
            <h1 class="page-title">Announcements</h1>
            <p class="text-muted">Latest updates from MARU administration</p>
        </div>
    </div>

    <?php if (!empty($announcements)): ?>
        <?php foreach ($announcements as $ann): ?>
        <div class="card p-4 mb-4" style="border-left: 4px solid <?= $ann['type'] === 'warning' ? 'var(--color-warning)' : ($ann['type'] === 'success' ? 'var(--color-success)' : 'var(--color-primary)') ?>;">
            <div class="flex items-start gap-3">
                <div class="flex-shrink-0 mt-1">
                    <?php if ($ann['type'] === 'warning'): ?>
                        <i class="ph ph-warning-circle text-warning text-xl"></i>
                    <?php elseif ($ann['type'] === 'success'): ?>
                        <i class="ph ph-check-circle text-success text-xl"></i>
                    <?php else: ?>
                        <i class="ph ph-info text-primary text-xl"></i>
                    <?php endif; ?>
                </div>
                <div class="flex-1">
                    <div class="flex justify-between items-start mb-1">
                        <div class="flex items-center gap-2">
                            <h3 class="text-base font-bold m-0"><?= htmlspecialchars($ann['title']) ?></h3>
                            <?php if (!$ann['is_read_by_me']): ?>
                                <span class="badge badge-primary" style="font-size: 0.6rem; padding: 2px 6px;">NEW</span>
                            <?php endif; ?>
                        </div>
                        <small class="text-muted flex-shrink-0 ml-2"><?= htmlspecialchars(date('M j, Y g:i A', strtotime($ann['created_at']))) ?></small>
                    </div>
                    <p class="text-muted text-sm mb-2"><?= nl2br(htmlspecialchars($ann['message'])) ?></p>
                    <small class="text-xs text-muted">Posted by <?= htmlspecialchars(($ann['first_name'] ?? '') . ' ' . ($ann['last_name'] ?? 'System')) ?></small>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="card p-8 text-center">
            <div class="flex flex-col items-center">
                <i class="ph ph-megaphone text-4xl text-muted mb-3"></i>
                <h3 class="heading-4 mb-2">No Announcements</h3>
                <p class="text-muted">There are no announcements for you at this time.</p>
            </div>
        </div>
    <?php endif; ?>
</div>
