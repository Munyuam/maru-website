<?php $layout = 'main'; ?>
<div class="container">
    <div class="page-header">
        <h1 class="page-title">Registration Status</h1>
        <p class="page-subtitle">Track your MARU registration progress</p>
    </div>

    <div class="card">
        <div class="timeline">
            <!-- Pending State -->
            <div class="timeline-item <?= ($status['step'] ?? 1) >= 1 ? 'completed' : '' ?>">
                <div class="timeline-marker"></div>
                <div class="timeline-content">
                    <h3 class="timeline-title">Application Submitted</h3>
                    <p class="timeline-description">Your registration details have been received and are pending review.</p>
                    <span class="timeline-date"><?= htmlspecialchars($status['submitted_date'] ?? 'Just now') ?></span>
                </div>
            </div>
            
            <!-- Under Review State -->
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
            
            <!-- Approved/Rejected State -->
            <div class="timeline-item <?= ($status['step'] ?? 1) >= 3 ? 'completed' : '' ?>">
                <div class="timeline-marker"></div>
                <div class="timeline-content">
                    <h3 class="timeline-title">Final Decision</h3>
                    <p class="timeline-description">Your registration has been processed.</p>
                    <?php if (($status['step'] ?? 1) >= 3): ?>
                        <?php if (($status['is_approved'] ?? true)): ?>
                            <span class="badge badge-success">Approved</span>
                        <?php else: ?>
                            <span class="badge badge-danger">Rejected</span>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
