<div class="page-header flex justify-between items-end mb-5">
    <div class="header-content">
        <h1 class="text-3xl font-bold m-0"><i class="ph ph-file-text text-primary mr-2"></i> Documents Queue</h1>
        <p class="text-muted m-0 mt-2">Review and verify uploaded player documentation.</p>
    </div>
    <div class="header-actions flex gap-3">
        <div class="filter-group flex bg-white rounded-pill shadow-sm p-1 border">
            <select class="form-control border-0 bg-transparent text-sm font-medium focus-none pr-4">
                <option>All Types</option>
                <option>Medical Clearance</option>
                <option>ID Verification</option>
                <option>Waiver</option>
            </select>
            <div class="w-px bg-light mx-1 my-2"></div>
            <select class="form-control border-0 bg-transparent text-sm font-medium focus-none pr-4">
                <option>Pending Only</option>
                <option>All Statuses</option>
            </select>
        </div>
    </div>
</div>

<div class="card shadow-sm border-0 rounded-xl overflow-hidden">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle">
                <thead class="bg-light text-uppercase text-muted text-xs font-bold tracking-wider border-bottom">
                    <tr>
                        <th class="border-top-0 py-4 pl-5">Document Details</th>
                        <th class="border-top-0 py-4">Submitted By</th>
                        <th class="border-top-0 py-4">Timestamp</th>
                        <th class="border-top-0 py-4 text-center">Status</th>
                        <th class="border-top-0 py-4 text-right pr-5">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($pendingDocuments)): ?>
                        <?php foreach ($pendingDocuments as $doc): ?>
                            <tr class="hover-bg-light transition <?= ($doc['verification_status'] ?? 'pending') === 'pending' ? 'bg-warning-light' : '' ?>" style="<?= ($doc['verification_status'] ?? 'pending') === 'pending' ? 'opacity: 0.95;' : 'opacity: 0.75;' ?>">
                                <td class="py-4 pl-5">
                                    <div class="flex items-center">
                                        <div class="bg-white text-dark shadow-sm rounded p-3 mr-4 flex items-center justify-center text-xl" style="width: 48px; height: 48px;">
                                            <i class="ph ph-file-text text-primary"></i>
                                        </div>
                                        <div>
                                            <h4 class="m-0 text-base font-bold text-dark mb-1"><?= htmlspecialchars(ucwords(str_replace('_', ' ', $doc['document_type']))) ?></h4>
                                            <span class="text-muted text-xs flex items-center"><i class="ph ph-paperclip mr-1"></i> <?= htmlspecialchars(basename($doc['file_path'] ?? 'document')) ?></span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <a href="/admin/players/<?= htmlspecialchars($doc['player_id'] ?? $doc['user_id']) ?>" class="text-dark font-bold hover-text-primary transition d-flex items-center">
                                        <div class="avatar avatar-sm bg-primary text-white rounded-circle mr-2 flex items-center justify-center text-xs" style="width:24px;height:24px;">P</div>
                                        Player #<?= htmlspecialchars($doc['player_id'] ?? $doc['user_id']) ?>
                                    </a>
                                </td>
                                <td>
                                    <div class="text-dark font-medium"><?= htmlspecialchars(date('M d, Y', strtotime($doc['uploaded_at'] ?? 'now'))) ?></div>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-white <?= ($doc['verification_status'] ?? 'pending') === 'verified' ? 'text-success border-success' : (($doc['verification_status'] ?? 'pending') === 'rejected' ? 'text-danger border-danger' : 'text-warning border-warning') ?> border rounded-pill px-3 py-1 shadow-sm">
                                        <?= htmlspecialchars(ucfirst($doc['verification_status'] ?? 'pending')) ?>
                                    </span>
                                </td>
                                <td class="text-right pr-5">
                                    <?php if (($doc['verification_status'] ?? 'pending') === 'pending'): ?>
                                        <form action="/admin/documents/<?= $doc['id'] ?>/verify" method="POST" class="inline-flex items-center gap-2">
                                            <input type="hidden" name="csrf_token" value="<?= \App\Helpers\Session::generateCsrfToken() ?>">
                                            <input type="text" name="notes" placeholder="Notes (optional)" class="form-control form-control-sm border-0 bg-white shadow-sm rounded-pill px-3 text-sm" style="width: 150px;">
                                            <button type="submit" name="status" value="verified" class="btn btn-success text-white rounded-pill px-3 py-1 shadow-sm font-medium hover-shadow transition text-sm">Verify</button>
                                            <button type="submit" name="status" value="rejected" class="btn btn-danger text-white rounded-pill px-3 py-1 shadow-sm font-medium hover-shadow transition text-sm">Reject</button>
                                        </form>
                                    <?php else: ?>
                                        <span class="text-muted text-sm font-medium"><i class="ph ph-check-circle text-success mr-1"></i> Reviewed</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                <i class="ph ph-tray text-4xl mb-3 text-light"></i>
                                <p class="m-0">No pending documents to review.</p>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
