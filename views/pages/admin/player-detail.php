<div class="page-header mb-4">
    <div class="flex items-center gap-3">
        <a href="/admin/players" class="btn btn-sm btn-light text-muted hover-bg-light rounded-pill px-3 shadow-sm"><i class="ph ph-arrow-left mr-1"></i> Back to Players</a>
    </div>
</div>

<?php if (!empty($player)): ?>
<div class="grid grid-3 gap-5">
    <div class="col-span-1">
        <div class="card shadow-sm border-0 rounded-lg mb-4 overflow-hidden">
            <div class="bg-primary text-center pt-5 pb-3 relative">
                <div class="avatar avatar-xl mx-auto bg-white text-primary flex items-center justify-center rounded-circle shadow-md border-4 border-white overflow-hidden" style="width: 120px; height: 120px; font-size: 3rem; margin-bottom: -60px; font-weight: bold;">
                    <?php if (!empty($player['avatar'])): ?>
                        <img src="/public/uploads/avatars/<?= htmlspecialchars($player['avatar']) ?>" alt="Avatar" class="avatar-img" loading="lazy">
                    <?php else: ?>
                        <?= strtoupper(substr($player['first_name'] ?? 'P', 0, 1)) ?><?= strtoupper(substr($player['last_name'] ?? '', 0, 1)) ?>
                    <?php endif; ?>
                </div>
            </div>
            <div class="card-body text-center pt-5 mt-4">
                <h2 class="text-2xl font-bold mb-1"><?= htmlspecialchars(($player['first_name'] ?? '') . ' ' . ($player['last_name'] ?? '')) ?></h2>
                <p class="text-muted mb-2 font-medium">Player ID: #<?= $player['id'] ?></p>
                <div class="mb-4">
                    <?php
                    $status = $player['registration_status'] ?? 'pending';
                    $statusMap = [
                        'pending' => ['badge-warning', 'Pending Approval'],
                        'under_review' => ['badge-info', 'Under Review'],
                        'approved' => ['badge-success', 'Approved'],
                        'rejected' => ['badge-danger', 'Rejected']
                    ];
                    [$badgeClass, $label] = $statusMap[$status] ?? ['badge-warning', 'Pending'];
                    ?>
                    <span class="badge <?= $badgeClass ?> rounded-pill px-3 py-1 shadow-sm"><?= $label ?></span>
                </div>
                
                <div class="info-list text-left border-top pt-4">
                    <div class="flex items-center mb-3">
                        <div class="text-muted w-8 text-center"><i class="ph ph-envelope"></i></div>
                        <div class="flex-1 font-medium"><?= htmlspecialchars($player['email'] ?? 'N/A') ?></div>
                    </div>
                    <div class="flex items-center mb-3">
                        <div class="text-muted w-8 text-center"><i class="ph ph-phone"></i></div>
                        <div class="flex-1 font-medium"><?= htmlspecialchars($player['phone'] ?? 'N/A') ?></div>
                    </div>
                    <div class="flex items-center mb-3">
                        <div class="text-muted w-8 text-center"><i class="ph ph-calendar"></i></div>
                        <div class="flex-1 font-medium"><?= htmlspecialchars($player['date_of_birth'] ?? 'N/A') ?></div>
                    </div>
                    <div class="flex items-center">
                        <div class="text-muted w-8 text-center"><i class="ph ph-clock"></i></div>
                        <div class="flex-1 font-medium">Registered: <?= date('M j, Y', strtotime($player['registered_at'] ?? 'now')) ?></div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="card shadow-sm border-0 rounded-lg">
            <div class="card-header bg-white border-bottom py-3">
                <h3 class="text-lg font-bold m-0"><i class="ph ph-clipboard-check text-primary mr-2"></i> Update Status</h3>
            </div>
            <div class="card-body">
                <form action="/admin/players/<?= $player['id'] ?>/status" method="POST">
                    <input type="hidden" name="csrf_token" value="<?= \App\Helpers\Session::generateCsrfToken() ?>">
                    <div class="form-group mb-4">
                        <label class="text-sm font-medium text-muted uppercase tracking-wider mb-2 d-block">Admin Notes (Optional)</label>
                        <textarea class="form-control bg-light border-0 rounded" name="notes" rows="3" placeholder="Add a note about this decision..."></textarea>
                    </div>
                    <div class="flex gap-2">
                        <button type="submit" name="status" value="approved" class="btn btn-success flex-1 rounded-pill shadow-sm"><i class="ph ph-check mr-1"></i> Approve</button>
                        <button type="submit" name="status" value="rejected" class="btn btn-danger flex-1 rounded-pill shadow-sm"><i class="ph ph-x mr-1"></i> Reject</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-span-2">
        <div class="card shadow-sm border-0 rounded-lg mb-4">
            <div class="card-header bg-white border-bottom py-3">
                <h2 class="text-lg font-bold m-0"><i class="ph ph-running text-primary mr-2"></i> Player Information</h2>
            </div>
            <div class="card-body p-4">
                <div class="grid grid-2 gap-4">
                    <div class="info-group p-3 bg-light rounded">
                        <label class="text-muted text-xs uppercase font-bold tracking-wider mb-1 d-block">Current Team</label>
                        <div class="text-dark font-medium text-lg flex items-center">
                            <?php if (!empty($player['team_name'])): ?>
                                <span class="text-dark"><?= htmlspecialchars($player['team_name']) ?></span>
                            <?php else: ?>
                                <span class="text-muted italic">Unassigned</span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="info-group p-3 bg-light rounded">
                        <label class="text-muted text-xs uppercase font-bold tracking-wider mb-1 d-block">Preferred Position</label>
                        <div class="text-dark font-medium text-lg"><?= htmlspecialchars($player['position'] ?? 'N/A') ?></div>
                    </div>
                    <div class="info-group p-3 bg-light rounded">
                        <label class="text-muted text-xs uppercase font-bold tracking-wider mb-1 d-block">Gender</label>
                        <div class="text-dark font-medium text-lg"><?= htmlspecialchars(ucfirst($player['gender'] ?? 'N/A')) ?></div>
                    </div>
                    <div class="info-group p-3 bg-light rounded">
                        <label class="text-muted text-xs uppercase font-bold tracking-wider mb-1 d-block">Nationality</label>
                        <div class="text-dark font-medium text-lg"><?= htmlspecialchars($player['nationality'] ?? 'N/A') ?></div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="card shadow-sm border-0 rounded-lg">
            <div class="card-header bg-white border-bottom py-3">
                <h2 class="text-lg font-bold m-0"><i class="ph ph-file-text text-primary mr-2"></i> Registration Notes</h2>
            </div>
            <div class="card-body p-4">
                <?php if (!empty($player['registration_notes'])): ?>
                    <p class="text-muted"><?= nl2br(htmlspecialchars($player['registration_notes'])) ?></p>
                <?php else: ?>
                    <p class="text-muted italic">No registration notes available.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php else: ?>
<div class="card shadow-sm border-0 rounded-lg p-8 text-center">
    <i class="ph ph-user text-4xl text-muted mb-4 block"></i>
    <h3 class="text-xl font-bold mb-2">Player Not Found</h3>
    <p class="text-muted mb-4">The requested player could not be found.</p>
    <a href="/admin/players" class="btn btn-primary">Back to Players</a>
</div>
<?php endif; ?>
