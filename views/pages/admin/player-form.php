<div class="page-header mb-4">
    <div class="flex items-center gap-3">
        <a href="/admin/players" class="btn btn-sm btn-light text-muted hover-bg-light rounded-pill px-3 shadow-sm"><i class="ph ph-arrow-left mr-1"></i> Back to Players</a>
    </div>
</div>

<div class="card max-w-2xl mx-auto shadow-lg border-0 rounded-xl overflow-hidden">
    <div class="card-header bg-white border-bottom py-4 px-5">
        <h2 class="text-2xl font-bold m-0"><i class="ph ph-user-plus text-primary mr-2"></i> Add New Player</h2>
        <p class="text-muted m-0 mt-1 text-sm">Register a player manually.</p>
    </div>
    <div class="card-body p-5">
        <form action="/admin/players/create" method="POST">
            <input type="hidden" name="csrf_token" value="<?= \App\Helpers\Session::generateCsrfToken() ?>">
            <div class="grid grid-2 gap-x-5 gap-y-4 mb-4">
                <div class="form-group">
                    <label class="font-bold text-dark text-sm uppercase tracking-wider mb-2 d-block">First Name <span class="text-danger">*</span></label>
                    <input type="text" name="first_name" class="form-control form-control-lg bg-light border-0 rounded-lg px-4" required>
                </div>
                <div class="form-group">
                    <label class="font-bold text-dark text-sm uppercase tracking-wider mb-2 d-block">Last Name <span class="text-danger">*</span></label>
                    <input type="text" name="last_name" class="form-control form-control-lg bg-light border-0 rounded-lg px-4" required>
                </div>
                <div class="form-group">
                    <label class="font-bold text-dark text-sm uppercase tracking-wider mb-2 d-block">Email <span class="text-danger">*</span></label>
                    <input type="email" name="email" class="form-control form-control-lg bg-light border-0 rounded-lg px-4" required>
                </div>
                <div class="form-group">
                    <label class="font-bold text-dark text-sm uppercase tracking-wider mb-2 d-block">Password <span class="text-danger">*</span></label>
                    <input type="password" name="password" class="form-control form-control-lg bg-light border-0 rounded-lg px-4" required minlength="6">
                </div>
                <div class="form-group">
                    <label class="font-bold text-dark text-sm uppercase tracking-wider mb-2 d-block">Phone <span class="text-danger">*</span></label>
                    <input type="text" name="phone" class="form-control form-control-lg bg-light border-0 rounded-lg px-4" required>
                </div>
                <div class="form-group">
                    <label class="font-bold text-dark text-sm uppercase tracking-wider mb-2 d-block">Date of Birth <span class="text-danger">*</span></label>
                    <input type="date" name="date_of_birth" class="form-control form-control-lg bg-light border-0 rounded-lg px-4" required>
                </div>
                <div class="form-group">
                    <label class="font-bold text-dark text-sm uppercase tracking-wider mb-2 d-block">Gender <span class="text-danger">*</span></label>
                    <select name="gender" class="form-control form-control-lg bg-light border-0 rounded-lg px-4" required>
                        <option value="">Select...</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                        <option value="other">Other</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="font-bold text-dark text-sm uppercase tracking-wider mb-2 d-block">Position <span class="text-danger">*</span></label>
                    <input type="text" name="position" class="form-control form-control-lg bg-light border-0 rounded-lg px-4" required>
                </div>
                <div class="form-group">
                    <label class="font-bold text-dark text-sm uppercase tracking-wider mb-2 d-block">Nationality <span class="text-danger">*</span></label>
                    <input type="text" name="nationality" class="form-control form-control-lg bg-light border-0 rounded-lg px-4" required>
                </div>
                <div class="form-group">
                    <label class="font-bold text-dark text-sm uppercase tracking-wider mb-2 d-block">Assign Team</label>
                    <select name="team_id" class="form-control form-control-lg bg-light border-0 rounded-lg px-4">
                        <option value="">-- No Team --</option>
                        <?php if (!empty($teams)): ?>
                            <?php foreach ($teams as $t): ?>
                                <option value="<?= $t['id'] ?>"><?= htmlspecialchars($t['name']) ?></option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>
            </div>
            <div class="border-top border-light pt-4 mt-5 flex justify-end gap-3">
                <a href="/admin/players" class="btn btn-light text-dark font-medium rounded-pill px-5 py-2">Cancel</a>
                <button type="submit" class="btn btn-primary font-bold rounded-pill px-5 py-2 shadow-md">Create Player <i class="ph ph-check ml-2"></i></button>
            </div>
        </form>
    </div>
</div>
