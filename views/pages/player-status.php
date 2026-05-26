<?php $layout = 'main'; ?>
<div class="container py-8">
    <div class="page-header mb-6">
        <h1 class="heading-2">Registration Status</h1>
        <p class="text-muted mt-1">Track your MARU registration progress</p>
    </div>

    <div class="grid grid-3 gap-6">
        <div class="col-span-2">
            <div class="card">
                <div class="card-header">
                    <h3 class="heading-4 m-0">Application Timeline</h3>
                </div>
                <div class="card-body">
                    <div class="timeline">
                        <div class="timeline-item <?= ($status['step'] ?? 1) >= 1 ? 'completed' : '' ?>">
                            <div class="timeline-marker"></div>
                            <div class="timeline-content">
                                <h3 class="timeline-title">Application Submitted</h3>
                                <p class="timeline-description">Your registration details have been received and are pending review.</p>
                                <span class="timeline-date"><?= htmlspecialchars($status['submitted_date'] ?? 'Just now') ?></span>
                            </div>
                        </div>

                        <div class="timeline-item <?= ($status['step'] ?? 1) >= 2 ? 'completed' : '' ?>">
                            <div class="timeline-marker"></div>
                            <div class="timeline-content">
                                <h3 class="timeline-title">Under Review</h3>
                                <p class="timeline-description">The administration team is currently verifying your documents and details.</p>
                                <?php if (($status['step'] ?? 1) == 2): ?>
                                    <span class="badge badge-warning">In Progress</span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="timeline-item <?= ($status['step'] ?? 1) >= 3 ? 'completed' : '' ?>">
                            <div class="timeline-marker"></div>
                            <div class="timeline-content">
                                <h3 class="timeline-title">Final Decision</h3>
                                <p class="timeline-description">Your registration has been processed.</p>
                                <?php if (($status['step'] ?? 1) >= 3): ?>
                                    <?php if ($status['is_approved']): ?>
                                        <span class="badge badge-success">Approved</span>
                                    <?php else: ?>
                                        <span class="badge badge-error">Rejected</span>
                                    <?php endif; ?>
                                    <?php if (!empty($status['reviewed_at'])): ?>
                                        <span class="timeline-date"><?= htmlspecialchars($status['reviewed_at']) ?></span>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-span-1">
            <div class="card">
                <div class="card-header">
                    <h3 class="heading-4 m-0">Status Summary</h3>
                </div>
                <div class="card-body">
                    <div class="flex flex-col gap-4">
                        <div class="flex items-center gap-3">
                            <div class="flex-center" style="width: 40px; height: 40px; border-radius: var(--radius-full); background: var(--color-primary-light); color: var(--color-primary);">
                                <i class="ph ph-identification-badge text-lg"></i>
                            </div>
                            <div>
                                <span class="text-xs text-muted block">Current Status</span>
                                <span class="font-medium">
                                    <?php
                                    $labelMap = ['pending' => 'Pending Review', 'under_review' => 'Under Review', 'approved' => 'Approved', 'rejected' => 'Rejected'];
                                    echo $labelMap[$status['status'] ?? 'pending'] ?? 'Unknown';
                                    ?>
                                </span>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="flex-center" style="width: 40px; height: 40px; border-radius: var(--radius-full); background: var(--color-primary-light); color: var(--color-primary);">
                                <i class="ph ph-calendar text-lg"></i>
                            </div>
                            <div>
                                <span class="text-xs text-muted block">Submitted</span>
                                <span class="font-medium"><?= htmlspecialchars($status['submitted_date'] ?? 'N/A') ?></span>
                            </div>
                        </div>
                        <?php if (!empty($status['reviewed_at'])): ?>
                        <div class="flex items-center gap-3">
                            <div class="flex-center" style="width: 40px; height: 40px; border-radius: var(--radius-full); background: var(--color-primary-light); color: var(--color-primary);">
                                <i class="ph ph-check-circle text-lg"></i>
                            </div>
                            <div>
                                <span class="text-xs text-muted block">Reviewed</span>
                                <span class="font-medium"><?= htmlspecialchars($status['reviewed_at']) ?></span>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
