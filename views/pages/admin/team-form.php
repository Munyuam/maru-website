<?php 
$pageTitle = 'Create Team';
include __DIR__ . '/../../layouts/admin.php'; 
?>

<div class="page-header mb-5">
    <div class="flex items-center gap-3">
        <a href="/admin/teams" class="btn btn-sm btn-light text-muted hover-bg-light rounded-pill px-3 shadow-sm"><i class="fas fa-arrow-left mr-1"></i> Back to Teams</a>
    </div>
</div>

<div class="card max-w-2xl mx-auto shadow-lg border-0 rounded-xl overflow-hidden">
    <div class="card-header bg-white border-bottom py-4 px-5">
        <h2 class="text-2xl font-bold m-0"><i class="fas fa-users-cog text-primary mr-2"></i> Create New Team</h2>
        <p class="text-muted m-0 mt-1 text-sm">Set up a new team profile and assign staff.</p>
    </div>
    <div class="card-body p-5">
        <form action="/admin/teams/create" method="POST">
            <div class="grid grid-2 gap-x-5 gap-y-4 mb-4">
                <div class="form-group col-span-2 mb-2">
                    <label for="team_name" class="font-bold text-dark text-sm uppercase tracking-wider mb-2 d-block">Team Name <span class="text-danger">*</span></label>
                    <input type="text" id="team_name" name="team_name" class="form-control form-control-lg bg-light border-0 rounded-lg px-4" required placeholder="e.g. Dragons, Tigers, Eagles...">
                </div>
                
                <div class="form-group mb-2">
                    <label for="division" class="font-bold text-dark text-sm uppercase tracking-wider mb-2 d-block">Division <span class="text-danger">*</span></label>
                    <select id="division" name="division" class="form-control form-control-lg bg-light border-0 rounded-lg px-4" required>
                        <option value="" disabled selected>Select Division</option>
                        <option value="U-12">U-12 Division</option>
                        <option value="U-14">U-14 Division</option>
                        <option value="U-16">U-16 Division</option>
                        <option value="U-18">U-18 Division</option>
                        <option value="Adult">Adult League</option>
                    </select>
                </div>
                
                <div class="form-group mb-2">
                    <label for="max_players" class="font-bold text-dark text-sm uppercase tracking-wider mb-2 d-block">Max Roster Size</label>
                    <input type="number" id="max_players" name="max_players" class="form-control form-control-lg bg-light border-0 rounded-lg px-4" value="22" min="11" max="30">
                </div>
                
                <div class="form-group col-span-2 mb-2 pt-2 border-top border-light mt-2">
                    <label for="coach_id" class="font-bold text-dark text-sm uppercase tracking-wider mb-2 d-block">Assign Head Coach</label>
                    <select id="coach_id" name="coach_id" class="form-control form-control-lg bg-light border-0 rounded-lg px-4">
                        <option value="">-- No Coach Assigned Yet --</option>
                        <option value="1">Coach Smith (Available)</option>
                        <option value="2">Emily Jones (Available)</option>
                    </select>
                    <small class="form-text text-muted mt-2"><i class="fas fa-info-circle mr-1"></i> You can skip this and assign a coach later.</small>
                </div>
                
                <div class="form-group col-span-2 mb-2 pt-2 border-top border-light mt-2">
                    <label class="font-bold text-dark text-sm uppercase tracking-wider mb-3 d-block">Team Colors</label>
                    <div class="flex gap-4 items-center">
                        <div class="flex flex-col items-center">
                            <label class="text-xs text-muted mb-1">Primary</label>
                            <input type="color" name="primary_color" class="form-control p-1 rounded-lg border-0 shadow-sm cursor-pointer" style="width: 60px; height: 60px;" value="#e3342f">
                        </div>
                        <div class="flex flex-col items-center">
                            <label class="text-xs text-muted mb-1">Secondary</label>
                            <input type="color" name="secondary_color" class="form-control p-1 rounded-lg border-0 shadow-sm cursor-pointer" style="width: 60px; height: 60px;" value="#ffffff">
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="border-top border-light pt-4 mt-5 flex justify-end gap-3 bg-white">
                <a href="/admin/teams" class="btn btn-light text-dark font-medium rounded-pill px-5 py-2">Cancel</a>
                <button type="submit" class="btn btn-primary font-bold rounded-pill px-5 py-2 shadow-md hover-shadow-lg transition">Create Team <i class="fas fa-check ml-2"></i></button>
            </div>
        </form>
    </div>
</div>
