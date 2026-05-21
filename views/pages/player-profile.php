<div class="container py-8">
    <div class="flex flex-between mb-6">
        <div>
            <h1 class="heading-2">My Profile</h1>
            <p class="text-muted mt-1">Manage your player registration and account details</p>
        </div>
        <a href="/player/profile/edit" class="btn btn-outline">
            <i class="ph ph-pencil-simple mr-2"></i> Edit Profile
        </a>
    </div>

    <?php if (empty($player)): ?>
        <div class="card p-8 text-center max-w-2xl mx-auto">
            <div class="flex flex-col items-center">
                <div class="avatar avatar-lg mb-4" style="width: 80px; height: 80px; font-size: 2rem; background: var(--color-primary-light); color: var(--color-primary);">
                    <i class="ph ph-user"></i>
                </div>
                <h2 class="heading-3 mb-2">Registration Not Started</h2>
                <p class="text-muted mb-6 max-w-md">You haven't started your player registration yet. Complete your profile to join the team.</p>
                <a href="/register/player" class="btn btn-primary">
                    <i class="ph ph-plus mr-2"></i> Start Registration
                </a>
            </div>
        </div>
    <?php else: ?>
        <div class="grid grid-3 gap-6">
            <div class="col-span-1">
                <div class="card">
                    <div class="card-body text-center">
                        <div class="avatar avatar-lg mx-auto mb-4" style="width: 80px; height: 80px; font-size: 1.75rem; background: var(--color-primary); color: white;">
                            <?= strtoupper(substr($player['first_name'] ?? 'P', 0, 1)) ?><?= strtoupper(substr($player['last_name'] ?? '', 0, 1)) ?>
                        </div>
                        <h2 class="heading-3 mb-1"><?= htmlspecialchars($player['first_name'] ?? '') ?> <?= htmlspecialchars($player['last_name'] ?? '') ?></h2>
                        <p class="text-muted text-sm mb-4"><?= htmlspecialchars($player['email'] ?? '') ?></p>
                        
                        <div class="mb-4">
                            <?php
                            $status = $player['registration_status'] ?? 'pending';
                            $statusLabels = [
                                'pending' => ['label' => 'Pending Review', 'class' => 'badge-warning'],
                                'under_review' => ['label' => 'Under Review', 'class' => 'badge-info'],
                                'approved' => ['label' => 'Approved', 'class' => 'badge-success'],
                                'rejected' => ['label' => 'Rejected', 'class' => 'badge-error']
                            ];
                            $statusInfo = $statusLabels[$status] ?? $statusLabels['pending'];
                            ?>
                            <span class="badge <?= $statusInfo['class'] ?>"><?= $statusInfo['label'] ?></span>
                        </div>

                        <div class="grid grid-2 gap-3 text-left mt-6 pt-4" style="border-top: 1px solid var(--color-border);">
                            <div>
                                <span class="text-xs text-muted block">Position</span>
                                <span class="font-medium text-sm"><?= htmlspecialchars($player['position'] ?? 'N/A') ?></span>
                            </div>
                            <div>
                                <span class="text-xs text-muted block">Team</span>
                                <span class="font-medium text-sm"><?= htmlspecialchars($player['team_name'] ?? 'None') ?></span>
                            </div>
                            <div>
                                <span class="text-xs text-muted block">Gender</span>
                                <span class="font-medium text-sm"><?= htmlspecialchars(ucfirst($player['gender'] ?? 'N/A')) ?></span>
                            </div>
                            <div>
                                <span class="text-xs text-muted block">Nationality</span>
                                <span class="font-medium text-sm"><?= htmlspecialchars($player['nationality'] ?? 'N/A') ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-span-2">
                <div class="card mb-6">
                    <div class="card-header">
                        <h3 class="heading-4 m-0">Personal Details</h3>
                    </div>
                    <div class="card-body">
                        <div class="grid grid-2 gap-4">
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
                                <span class="font-medium"><?= htmlspecialchars($player['position'] ?? 'N/A') ?></span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mb-6">
                    <div class="card-header">
                        <h3 class="heading-4 m-0">My Documents</h3>
                    </div>
                    <div class="card-body">
                        <?php if (!empty($documents)): ?>
                            <?php foreach ($documents as $doc): ?>
                                <div class="flex flex-between items-center py-3" style="border-bottom: 1px solid var(--color-border);">
                                    <div>
                                        <h4 class="font-medium mb-1"><?= htmlspecialchars(ucwords(str_replace('_', ' ', $doc['document_type']))) ?></h4>
                                        <span class="text-sm text-muted">Status: 
                                            <span class="badge <?= $doc['status'] === 'verified' ? 'badge-success' : ($doc['status'] === 'rejected' ? 'badge-error' : 'badge-warning') ?>">
                                                <?= htmlspecialchars($doc['status']) ?>
                                            </span>
                                        </span>
                                    </div>
                                    <?php if ($doc['status'] === 'rejected' && !empty($doc['notes'])): ?>
                                        <span class="text-sm" style="color: var(--color-error);"><?= htmlspecialchars($doc['notes']) ?></span>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p class="text-muted text-center py-4">No documents uploaded yet.</p>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h3 class="heading-4 m-0">Upload New Document</h3>
                    </div>
                    <div class="card-body">
                        <form action="/player/documents/upload" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="csrf_token" value="<?= \App\Helpers\Session::generateCsrfToken() ?>">
                            <div class="grid grid-2 gap-4 mb-4">
                                <div>
                                    <label for="document_type" class="form-label">Document Type</label>
                                    <select name="document_type" id="document_type" class="form-select" required>
                                        <option value="">Select Type...</option>
                                        <option value="id_document">ID Document</option>
                                        <option value="medical_clearance">Medical Clearance</option>
                                        <option value="coaching_cert">Coaching Certificate</option>
                                    </select>
                                </div>
                                <div>
                                    <label for="document" class="form-label">File</label>
                                    <input type="file" name="document" id="document" class="form-input" required>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">
                                <i class="ph ph-upload mr-2"></i> Upload Document
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>
