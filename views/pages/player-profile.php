<?php $layout = 'main'; ?>
<div class="container">
    <div class="page-header">
        <h1 class="page-title">Player Profile</h1>
        <span class="badge badge-success">Registered</span>
    </div>

    <div class="grid grid-3">
        <div class="col-span-1">
            <div class="card profile-card">
                <div class="profile-header">
                    <div class="profile-avatar">
                        <img src="<?= htmlspecialchars($player['avatar_url'] ?? '/assets/images/default-avatar.png') ?>" alt="Profile Picture">
                    </div>
                    <h2 class="profile-name"><?= htmlspecialchars($player['first_name'] ?? 'John') ?> <?= htmlspecialchars($player['last_name'] ?? 'Doe') ?></h2>
                    <p class="profile-team"><?= htmlspecialchars($player['team_name'] ?? 'No Team Assigned') ?></p>
                </div>
                <div class="profile-stats grid grid-2">
                    <div class="stat-item">
                        <span class="stat-label">Position</span>
                        <span class="stat-value"><?= htmlspecialchars($player['position'] ?? 'N/A') ?></span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-label">Age</span>
                        <span class="stat-value"><?= htmlspecialchars($player['age'] ?? 'N/A') ?></span>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-span-2">
            <div class="card">
                <h3 class="card-title">Personal Details</h3>
                <div class="details-list">
                    <div class="detail-item">
                        <span class="detail-label">Email:</span>
                        <span class="detail-value"><?= htmlspecialchars($player['email'] ?? 'john.doe@example.com') ?></span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Phone:</span>
                        <span class="detail-value"><?= htmlspecialchars($player['phone'] ?? '+1234567890') ?></span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Date of Birth:</span>
                        <span class="detail-value"><?= htmlspecialchars($player['date_of_birth'] ?? '1990-01-01') ?></span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Nationality:</span>
                        <span class="detail-value"><?= htmlspecialchars($player['nationality'] ?? 'N/A') ?></span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Gender:</span>
                        <span class="detail-value"><?= htmlspecialchars($player['gender'] ?? 'N/A') ?></span>
                    </div>
                </div>
            </div>
            
            <div class="card mt-4">
                <h3 class="card-title">My Documents</h3>
                <div class="documents-list mb-4">
                    <?php if (!empty($documents)): ?>
                        <?php foreach ($documents as $doc): ?>
                            <div class="document-item flex justify-between items-center p-3 border-bottom">
                                <div>
                                    <h4 class="m-0 text-base font-bold"><?= htmlspecialchars(ucwords(str_replace('_', ' ', $doc['document_type']))) ?></h4>
                                    <span class="text-sm text-muted">Status: 
                                        <span class="badge <?= $doc['status'] === 'verified' ? 'badge-success' : ($doc['status'] === 'rejected' ? 'badge-danger' : 'badge-warning') ?>">
                                            <?= htmlspecialchars($doc['status']) ?>
                                        </span>
                                    </span>
                                </div>
                                <?php if ($doc['status'] === 'rejected' && !empty($doc['notes'])): ?>
                                    <div class="text-danger text-sm max-w-xs"><?= htmlspecialchars($doc['notes']) ?></div>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p class="text-muted p-3">No documents uploaded yet.</p>
                    <?php endif; ?>
                </div>

                <h4 class="text-md font-bold mb-3 border-top pt-3">Upload New Document</h4>
                <form action="/player/documents/upload" method="POST" enctype="multipart/form-data" class="upload-form bg-light p-4 rounded-lg border">
                    <div class="form-group mb-3">
                        <label for="document_type" class="form-label font-medium text-dark">Document Type</label>
                        <select name="document_type" id="document_type" class="form-control form-input shadow-sm" required>
                            <option value="">Select Type...</option>
                            <option value="id_document">ID Document</option>
                            <option value="medical_clearance">Medical Clearance</option>
                            <option value="coaching_cert">Coaching Certificate</option>
                        </select>
                    </div>
                    <div class="form-group mb-4">
                        <label for="document" class="form-label font-medium text-dark">File</label>
                        <input type="file" name="document" id="document" class="form-control form-input shadow-sm p-2 bg-white" required>
                    </div>
                    <button type="submit" class="btn btn-primary rounded-pill px-4 shadow-sm hover-shadow transition">
                        <i class="fas fa-upload mr-2"></i> Upload Document
                    </button>
                </form>
            </div>
            
            <div class="card mt-4">
                <h3 class="card-title">Registration History</h3>
                <p>No recent history available.</p>
            </div>
        </div>
    </div>
</div>
