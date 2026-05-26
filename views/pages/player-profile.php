<div class="container py-8">
    <?php if (empty($player)): ?>
        <div class="card p-8 text-center max-w-2xl mx-auto">
            <div class="flex flex-col items-center">
                <div class="avatar avatar-lg mb-4" style="width: 80px; height: 80px; font-size: 2rem; background: var(--color-primary-light); color: var(--color-primary);">
                    <i class="ph ph-user"></i>
                </div>
                <h2 class="heading-3 mb-2">Registration Not Started</h2>
                <p class="text-muted mb-6 max-w-md">You haven't started your player registration yet. Complete your profile to join the team.</p>
                <a  href="<?= url('/register/player') ?>"  class="btn btn-primary">
                    <i class="ph ph-plus mr-2"></i> Start Registration
                </a>
            </div>
        </div>
    <?php else:
        $regStatus = $player['registration_status'] ?? 'pending';
        $statusLabels = [
            'pending' => ['label' => 'Pending Review', 'class' => 'badge-warning'],
            'under_review' => ['label' => 'Under Review', 'class' => 'badge-info'],
            'approved' => ['label' => 'Approved', 'class' => 'badge-success'],
            'rejected' => ['label' => 'Rejected', 'class' => 'badge-error']
        ];
        $statusInfo = $statusLabels[$regStatus] ?? $statusLabels['pending'];
    ?>

    <?php if (!empty($announcements)): ?>
    <!-- Announcements -->
    <div class="mb-6">
        <?php foreach ($announcements as $ann): ?>
        <div class="card p-4 mb-3 <?= !$ann['is_read_by_me'] ? 'border-left-primary' : '' ?>" style="border-left: 4px solid <?= !$ann['is_read_by_me'] ? 'var(--color-primary)' : 'transparent' ?>;">
            <div class="flex items-start gap-3">
                <div class="flex-shrink-0 mt-1">
                    <?php if ($ann['type'] === 'warning'): ?>
                        <i class="ph ph-warning-circle text-warning text-lg"></i>
                    <?php elseif ($ann['type'] === 'success'): ?>
                        <i class="ph ph-check-circle text-success text-lg"></i>
                    <?php else: ?>
                        <i class="ph ph-info text-primary text-lg"></i>
                    <?php endif; ?>
                </div>
                <div class="flex-1">
                    <div class="flex justify-between items-start mb-1">
                        <h4 class="text-sm font-bold m-0"><?= htmlspecialchars($ann['title']) ?></h4>
                        <div class="flex items-center gap-2 flex-shrink-0 ml-2">
                            <?php if (!$ann['is_read_by_me']): ?>
                                <span class="badge badge-primary" style="font-size: 0.6rem; padding: 2px 6px;">NEW</span>
                            <?php endif; ?>
                            <small class="text-xs text-muted"><?= htmlspecialchars(date('M j', strtotime($ann['created_at']))) ?></small>
                        </div>
                    </div>
                    <p class="text-sm text-muted mb-0"><?= nl2br(htmlspecialchars($ann['message'])) ?></p>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>

    <!-- Top Banner -->
    <div class="card p-6 mb-6" style="background: linear-gradient(135deg, var(--color-primary), #1a4a8a); color: white;">
        <div class="flex flex-between items-center flex-wrap gap-4">
            <div class="flex items-center gap-4">
                <div class="flex-center" style="width: 56px; height: 56px; border-radius: var(--radius-full); background: rgba(255,255,255,0.2); font-size: 1.5rem; font-weight: 700; overflow: hidden;">
                    <?php if (!empty($player['avatar'])): ?>
                        <img  src="<?= url('/public/uploads/avatars/' . htmlspecialchars($player['avatar'])) ?>"  alt="Avatar" style="width: 100%; height: 100%; object-fit: cover;">
                    <?php else: ?>
                        <?= strtoupper(substr($player['first_name'] ?? 'P', 0, 1)) ?><?= strtoupper(substr($player['last_name'] ?? '', 0, 1)) ?>
                    <?php endif; ?>
                </div>
                <div>
                    <h1 style="font-size: 1.5rem; font-weight: 700; margin: 0;">Welcome, <?= htmlspecialchars($player['first_name'] ?? 'Player') ?>!</h1>
                    <p style="margin: 0.25rem 0 0; opacity: 0.85;"><?= htmlspecialchars($player['team_name'] ?? 'No team assigned') ?></p>
                </div>
            </div>
            <div class="flex items-center gap-3 flex-wrap">
                <span class="badge" style="background: rgba(255,255,255,0.2); color: white; border: 1px solid rgba(255,255,255,0.3);">
                    <i class="ph ph-soccer-ball mr-1"></i> <?= htmlspecialchars(ucfirst($player['position'] ?? 'N/A')) ?>
                </span>
                <span class="badge <?= $statusInfo['class'] ?>"><?= $statusInfo['label'] ?></span>
                <a  href="<?= url('/player/profile/edit') ?>"  class="btn" style="background: white; color: var(--color-primary); font-weight: 600;">
                    <i class="ph ph-pencil-simple mr-1"></i> Edit
                </a>
            </div>
        </div>
    </div>

    <!-- Profile Card -->
    <div class="card">
        <!-- Section: Personal Info -->
        <div class="p-6">
            <h3 class="heading-4 mb-4 flex items-center gap-2">
                <i class="ph ph-user-circle text-primary"></i> Personal Information
            </h3>
            <div class="grid grid-2 gap-x-8 gap-y-4">
                <div>
                    <span class="text-xs text-muted block mb-1">Full Name</span>
                    <span class="font-medium"><?= htmlspecialchars($player['first_name'] ?? '') ?> <?= htmlspecialchars($player['last_name'] ?? '') ?></span>
                </div>
                <div>
                    <span class="text-xs text-muted block mb-1">Email</span>
                    <span class="font-medium"><?= htmlspecialchars($player['email'] ?? 'N/A') ?></span>
                </div>
                <div>
                    <span class="text-xs text-muted block mb-1">Phone</span>
                    <span class="font-medium"><?= htmlspecialchars($player['phone'] ?? 'N/A') ?></span>
                </div>
                <div>
                    <span class="text-xs text-muted block mb-1">Date of Birth</span>
                    <span class="font-medium"><?= htmlspecialchars($player['date_of_birth'] ?? 'N/A') ?></span>
                </div>
                <div>
                    <span class="text-xs text-muted block mb-1">Nationality</span>
                    <span class="font-medium"><?= htmlspecialchars($player['nationality'] ?? 'N/A') ?></span>
                </div>
                <div>
                    <span class="text-xs text-muted block mb-1">Gender</span>
                    <span class="font-medium"><?= htmlspecialchars(ucfirst($player['gender'] ?? 'N/A')) ?></span>
                </div>
                <div>
                    <span class="text-xs text-muted block mb-1">Position</span>
                    <span class="font-medium"><?= htmlspecialchars(ucfirst($player['position'] ?? 'N/A')) ?></span>
                </div>
                <div>
                    <span class="text-xs text-muted block mb-1">Team</span>
                    <span class="font-medium"><?= htmlspecialchars($player['team_name'] ?? 'Unassigned') ?></span>
                </div>
                <?php if (!empty($player['address'])): ?>
                <div style="grid-column: span 2;">
                    <span class="text-xs text-muted block mb-1">Address</span>
                    <span class="font-medium"><?= htmlspecialchars($player['address']) ?></span>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <hr style="border: none; border-top: 1px solid var(--color-border); margin: 0;">

        <!-- Section: Experience & Emergency -->
        <div class="p-6">
            <div class="grid grid-2 gap-8">
                <div>
                    <h4 class="font-medium text-sm mb-3 flex items-center gap-2">
                        <i class="ph ph-trophy text-primary"></i> Playing Experience
                    </h4>
                    <div class="grid grid-2 gap-4">
                        <div>
                            <span class="text-xs text-muted block mb-1">Years</span>
                            <span class="font-medium"><?= htmlspecialchars((string)($player['playing_experience'] ?? '0')) ?> years</span>
                        </div>
                        <div>
                            <span class="text-xs text-muted block mb-1">Previous Clubs</span>
                            <span class="font-medium"><?= !empty($player['previous_clubs']) ? htmlspecialchars($player['previous_clubs']) : 'None' ?></span>
                        </div>
                    </div>
                </div>
                <div>
                    <h4 class="font-medium text-sm mb-3 flex items-center gap-2">
                        <i class="ph ph-phone text-primary"></i> Emergency Contact
                    </h4>
                    <?php if (!empty($player['emergency_contact_name'])): ?>
                    <div class="grid grid-2 gap-4">
                        <div>
                            <span class="text-xs text-muted block mb-1">Name</span>
                            <span class="font-medium"><?= htmlspecialchars($player['emergency_contact_name']) ?></span>
                        </div>
                        <div>
                            <span class="text-xs text-muted block mb-1">Phone</span>
                            <span class="font-medium"><?= htmlspecialchars($player['emergency_contact_phone'] ?? 'N/A') ?></span>
                        </div>
                        <div style="grid-column: span 2;">
                            <span class="text-xs text-muted block mb-1">Relationship</span>
                            <span class="font-medium"><?= htmlspecialchars($player['emergency_contact_relationship'] ?? 'N/A') ?></span>
                        </div>
                    </div>
                    <?php else: ?>
                    <p class="text-muted text-sm">
                        <a  href="<?= url('/player/profile/edit') ?>"  style="color: var(--color-primary); text-decoration: none;">Add emergency contact <i class="ph ph-arrow-right"></i></a>
                    </p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <hr style="border: none; border-top: 1px solid var(--color-border); margin: 0;">

        <!-- Section: Status -->
        <div class="p-6">
            <div class="flex flex-wrap items-center gap-4">
                <div class="flex items-center gap-2">
                    <span class="text-xs text-muted">Status Step:</span>
                    <span class="font-medium text-sm"><?= ($status['step'] ?? 1) ?> of 3</span>
                </div>
                <?php if ($status): ?>
                <div class="flex items-center gap-2">
                    <span class="text-xs text-muted">Submitted:</span>
                    <span class="font-medium text-sm"><?= htmlspecialchars($status['submitted_date'] ?? 'N/A') ?></span>
                </div>
                <?php if (!empty($status['reviewed_at'])): ?>
                <div class="flex items-center gap-2">
                    <span class="text-xs text-muted">Reviewed:</span>
                    <span class="font-medium text-sm"><?= htmlspecialchars($status['reviewed_at']) ?></span>
                </div>
                <?php endif; ?>
                <?php endif; ?>
                <a  href="<?= url('/player/status') ?>"  class="text-sm" style="color: var(--color-primary); text-decoration: none; margin-left: auto;">
                    Full timeline <i class="ph ph-arrow-right"></i>
                </a>
            </div>
            <?php if ($regStatus === 'rejected' && !empty($player['registration_notes'])): ?>
            <div class="mt-3 p-3" style="background: #fef2f2; border-radius: var(--radius-md);">
                <span class="text-xs font-medium" style="color: var(--color-error);">
                    <i class="ph ph-warning mr-1"></i> <?= htmlspecialchars($player['registration_notes']) ?>
                </span>
            </div>
            <?php endif; ?>
        </div>

        <hr style="border: none; border-top: 1px solid var(--color-border); margin: 0;">

        <!-- Section: Documents -->
        <div class="p-6">
            <h3 class="heading-4 mb-4 flex items-center gap-2">
                <i class="ph ph-files text-primary"></i> Documents
            </h3>
            <?php if (!empty($documents)): ?>
                <?php foreach ($documents as $i => $doc): ?>
                    <div class="flex flex-between items-center py-3 <?= $i < count($documents) - 1 ? 'mb-2' : '' ?>" <?= $i < count($documents) - 1 ? 'style="border-bottom: 1px solid var(--color-border);"' : '' ?>>
                        <div class="flex items-center gap-3">
                            <div class="flex-center" style="width: 36px; height: 36px; border-radius: var(--radius-md); background: var(--color-bg-tertiary); flex-shrink: 0;">
                                <i class="ph ph-file-text text-muted"></i>
                            </div>
                            <div>
                                <span class="font-medium text-sm"><?= htmlspecialchars(ucwords(str_replace('_', ' ', $doc['document_type']))) ?></span>
                                <?php if (!empty($doc['original_filename'])): ?>
                                <span class="text-xs text-muted block"><?= htmlspecialchars($doc['original_filename']) ?></span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <span class="badge <?= $doc['verification_status'] === 'verified' ? 'badge-success' : ($doc['verification_status'] === 'rejected' ? 'badge-error' : 'badge-warning') ?>">
                            <?= htmlspecialchars($doc['verification_status']) ?>
                        </span>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-muted text-sm mb-4">No documents uploaded yet.</p>
            <?php endif; ?>

            <form  action="<?= url('/player/documents/upload') ?>"  method="POST" enctype="multipart/form-data" class="mt-4 flex flex-wrap gap-3 items-end p-4" style="background: var(--color-bg-tertiary); border-radius: var(--radius-md);">
                <input type="hidden" name="csrf_token" value="<?= \App\Helpers\Session::generateCsrfToken() ?>">
                <div style="flex: 1; min-width: 160px;">
                    <label for="document_type" class="text-xs text-muted block mb-1">Type</label>
                    <select name="document_type" id="document_type" class="form-select" required>
                        <option value="">Select...</option>
                        <option value="id_document">ID Document</option>
                        <option value="medical_clearance">Medical Clearance</option>
                        <option value="coaching_cert">Coaching Certificate</option>
                    </select>
                </div>
                <div style="flex: 1; min-width: 160px;">
                    <label for="document" class="text-xs text-muted block mb-1">File</label>
                    <input type="file" name="document" id="document" class="form-input" required>
                </div>
                <button type="submit" class="btn btn-primary">
                    <i class="ph ph-upload mr-1"></i> Upload
                </button>
            </form>
        </div>
    </div>
    <?php endif; ?>
</div>
