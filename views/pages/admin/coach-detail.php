<div class="page-header mb-4">
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-3">
            <a href="/admin/coaches" class="btn btn-sm btn-light text-muted hover-bg-light rounded-pill px-3 shadow-sm"><i class="ph ph-arrow-left mr-1"></i> Back</a>
        </div>
    </div>
</div>

<?php if (!empty($coach)): ?>
<div class="grid grid-3 gap-5">
    <div class="col-span-1">
        <div class="card shadow-sm border-0 rounded-lg mb-4 text-center overflow-hidden">
            <div class="bg-primary h-24"></div>
            <div class="card-body pt-0 relative">
                <div class="avatar avatar-xl mx-auto bg-white text-primary flex items-center justify-center rounded-circle shadow-md border-4 border-white overflow-hidden" style="width: 120px; height: 120px; font-size: 3rem; margin-top: -60px; margin-bottom: 1rem; font-weight: bold;">
                    <?php if (!empty($coach['avatar'])): ?>
                        <img src="/public/uploads/avatars/<?= htmlspecialchars($coach['avatar']) ?>" alt="Avatar" class="avatar-img" loading="lazy">
                    <?php else: ?>
                        <?= strtoupper(substr($coach['first_name'] ?? 'C', 0, 1)) ?><?= strtoupper(substr($coach['last_name'] ?? '', 0, 1)) ?>
                    <?php endif; ?>
                </div>
                <h2 class="text-2xl font-bold mb-1"><?= htmlspecialchars(($coach['first_name'] ?? '') . ' ' . ($coach['last_name'] ?? '')) ?></h2>
                <p class="text-primary font-medium mb-3"><?= htmlspecialchars($coach['coaching_specialty'] ?? 'Coach') ?></p>
                <div class="mb-4">
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
                    <span class="badge <?= $badgeClass ?> rounded-pill px-3 py-1 shadow-sm"><?= $label ?></span>
                </div>
                
                <div class="info-list text-left border-top pt-4">
                    <div class="flex items-center mb-3">
                        <div class="text-muted w-8 text-center"><i class="ph ph-envelope"></i></div>
                        <div class="flex-1 text-dark font-medium"><?= htmlspecialchars($coach['email'] ?? 'N/A') ?></div>
                    </div>
                    <div class="flex items-center mb-3">
                        <div class="text-muted w-8 text-center"><i class="ph ph-phone"></i></div>
                        <div class="flex-1 text-dark font-medium"><?= htmlspecialchars($coach['phone'] ?? 'N/A') ?></div>
                    </div>
                    <div class="flex items-center">
                        <div class="text-muted w-8 text-center"><i class="ph ph-calendar"></i></div>
                        <div class="flex-1 text-dark font-medium">Joined <?= date('M Y', strtotime($coach['created_at'] ?? 'now')) ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-span-2">
        <div class="card shadow-sm border-0 rounded-lg mb-4">
            <div class="card-header bg-white border-bottom py-3 flex justify-between items-center">
                <h2 class="text-lg font-bold m-0"><i class="ph ph-users text-primary mr-2"></i> Assigned Team</h2>
            </div>
            <div class="card-body p-4">
                <?php if (!empty($coach['team_name'])): ?>
                    <div class="flex items-center p-4 border border-light rounded-lg bg-light-primary hover-shadow transition relative overflow-hidden">
                        <div class="absolute top-0 bottom-0 left-0 w-1 bg-primary"></div>
                        <div class="flex-1">
                            <div class="flex items-center mb-1">
                                <h3 class="text-xl font-bold m-0 text-dark"><?= htmlspecialchars($coach['team_name']) ?></h3>
                            </div>
                            <p class="text-muted mb-0">Currently assigned to this team.</p>
                        </div>
                        <div>
                            <a href="/admin/teams/<?= $coach['team_id'] ?>" class="btn btn-primary rounded-pill px-4 shadow-sm">View Team <i class="ph ph-arrow-right ml-1"></i></a>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="text-center py-4 text-muted">
                        <i class="ph ph-trophy text-3xl mb-2 block"></i>
                        <p class="m-0">No team assigned yet.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        
        <div class="card shadow-sm border-0 rounded-lg mb-4">
            <div class="card-header bg-white border-bottom py-3">
                <h3 class="text-lg font-bold m-0"><i class="ph ph-clipboard-check text-primary mr-2"></i> Update Status</h3>
            </div>
            <div class="card-body">
                <form action="/admin/coaches/<?= $coach['id'] ?>/status" method="POST">
                    <input type="hidden" name="csrf_token" value="<?= \App\Helpers\Session::generateCsrfToken() ?>">
                    <div class="flex gap-2">
                        <button type="submit" name="status" value="approved" class="btn btn-success flex-1 rounded-pill shadow-sm"><i class="ph ph-check mr-1"></i> Approve</button>
                        <button type="submit" name="status" value="rejected" class="btn btn-danger flex-1 rounded-pill shadow-sm"><i class="ph ph-x mr-1"></i> Reject</button>
                        <button type="submit" name="status" value="pending" class="btn btn-light flex-1 rounded-pill shadow-sm"><i class="ph ph-clock mr-1"></i> Reset to Pending</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="card shadow-sm border-0 rounded-lg">
            <div class="card-header bg-white border-bottom py-3">
                <h2 class="text-lg font-bold m-0"><i class="ph ph-certificate text-primary mr-2"></i> Qualifications & Experience</h2>
            </div>
            <div class="card-body p-4">
                <div class="grid grid-2 gap-4">
                    <?php if (!empty($coach['qualification'])): ?>
                        <div class="info-group p-3 bg-light rounded">
                            <label class="text-muted text-xs uppercase font-bold tracking-wider mb-1 d-block">Qualification</label>
                            <div class="text-dark font-medium"><?= htmlspecialchars($coach['qualification']) ?></div>
                        </div>
                    <?php endif; ?>
                    <?php if (!empty($coach['years_experience'])): ?>
                        <div class="info-group p-3 bg-light rounded">
                            <label class="text-muted text-xs uppercase font-bold tracking-wider mb-1 d-block">Years Experience</label>
                            <div class="text-dark font-medium"><?= htmlspecialchars($coach['years_experience']) ?> years</div>
                        </div>
                    <?php endif; ?>
                    <?php if (!empty($coach['date_of_birth'])): ?>
                        <div class="info-group p-3 bg-light rounded">
                            <label class="text-muted text-xs uppercase font-bold tracking-wider mb-1 d-block">Date of Birth</label>
                            <div class="text-dark font-medium"><?= htmlspecialchars($coach['date_of_birth']) ?></div>
                        </div>
                    <?php endif; ?>
                    <?php if (!empty($coach['address'])): ?>
                        <div class="info-group p-3 bg-light rounded">
                            <label class="text-muted text-xs uppercase font-bold tracking-wider mb-1 d-block">Address</label>
                            <div class="text-dark font-medium"><?= htmlspecialchars($coach['address']) ?></div>
                        </div>
                    <?php endif; ?>
                </div>
                <?php if (empty($coach['qualification']) && empty($coach['years_experience']) && empty($coach['date_of_birth']) && empty($coach['address'])): ?>
                    <p class="text-muted italic text-center py-4">No additional information provided.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php else: ?>
<div class="card shadow-sm border-0 rounded-lg p-8 text-center">
    <i class="ph ph-chalkboard-teacher text-4xl text-muted mb-4 block"></i>
    <h3 class="text-xl font-bold mb-2">Coach Not Found</h3>
    <p class="text-muted mb-4">The requested coach could not be found.</p>
    <a href="/admin/coaches" class="btn btn-primary">Back to Coaches</a>
</div>
<?php endif; ?>
