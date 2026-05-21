<?php 
$pageTitle = 'Team Details';
include __DIR__ . '/../../layouts/admin.php'; 
?>

<div class="page-header mb-5">
    <div class="flex justify-between items-center">
        <div class="flex items-center gap-4">
            <a href="/admin/teams" class="btn btn-sm btn-light text-muted hover-bg-light rounded-circle shadow-sm flex items-center justify-center p-0" style="width: 36px; height: 36px;"><i class="fas fa-arrow-left"></i></a>
            <div>
                <h1 class="text-3xl font-bold m-0 flex items-center">Dragons <span class="badge bg-danger-light text-danger border border-danger ml-3 rounded-pill text-sm px-3 py-1 font-medium align-middle">U-18 Division</span></h1>
            </div>
        </div>
        <div class="actions flex gap-3">
            <button class="btn btn-outline-secondary rounded-pill px-4 bg-white shadow-sm font-medium"><i class="fas fa-cog mr-2"></i> Settings</button>
            <button class="btn btn-primary rounded-pill px-4 shadow-sm font-bold"><i class="fas fa-user-plus mr-2"></i> Add Player</button>
        </div>
    </div>
</div>

<div class="grid grid-4 gap-4 mb-5">
    <div class="card stat-card shadow-sm border-0 rounded-xl">
        <div class="card-body p-4 flex items-center">
            <div class="stat-icon text-primary bg-primary-light rounded-lg p-3 mr-4 flex items-center justify-center" style="width: 56px; height: 56px;"><i class="fas fa-users fa-2x"></i></div>
            <div>
                <p class="stat-label mb-1 text-muted text-sm font-bold uppercase tracking-wider">Roster Fill</p>
                <h3 class="stat-value mb-0 text-2xl font-bold text-dark">18 <span class="text-muted text-sm font-normal">/ 22 max</span></h3>
            </div>
        </div>
    </div>
    <div class="card stat-card shadow-sm border-0 rounded-xl">
        <div class="card-body p-4 flex items-center">
            <div class="stat-icon text-success bg-success-light rounded-lg p-3 mr-4 flex items-center justify-center" style="width: 56px; height: 56px;"><i class="fas fa-user-tie fa-2x"></i></div>
            <div>
                <p class="stat-label mb-1 text-muted text-sm font-bold uppercase tracking-wider">Head Coach</p>
                <h3 class="stat-value mb-0 text-xl font-bold text-dark">Coach Smith</h3>
            </div>
        </div>
    </div>
    <div class="card stat-card shadow-sm border-0 rounded-xl">
        <div class="card-body p-4 flex items-center">
            <div class="stat-icon text-warning bg-warning-light rounded-lg p-3 mr-4 flex items-center justify-center" style="width: 56px; height: 56px;"><i class="fas fa-calendar-check fa-2x"></i></div>
            <div>
                <p class="stat-label mb-1 text-muted text-sm font-bold uppercase tracking-wider">Next Match</p>
                <h3 class="stat-value mb-0 text-xl font-bold text-dark">Oct 24 <span class="text-muted text-sm font-normal italic">vs Tigers</span></h3>
            </div>
        </div>
    </div>
    <div class="card stat-card shadow-sm border-0 rounded-xl bg-primary text-white">
        <div class="card-body p-4 flex flex-col justify-center items-center text-center">
            <p class="stat-label mb-1 text-white text-sm opacity-80 font-bold uppercase tracking-wider">Team Status</p>
            <h3 class="stat-value mb-0 text-2xl font-bold">Active Season</h3>
        </div>
    </div>
</div>

<div class="card shadow-sm border-0 rounded-xl overflow-hidden">
    <div class="card-header bg-white border-bottom py-4 px-5 flex justify-between items-center">
        <h2 class="text-xl font-bold m-0"><i class="fas fa-clipboard-list text-primary mr-2"></i> Official Roster</h2>
        <div class="search-box relative w-64">
            <i class="fas fa-search absolute text-muted" style="left: 12px; top: 50%; transform: translateY(-50%);"></i>
            <input type="text" class="form-control form-control-sm pl-5 rounded-pill bg-light border-0 py-2" placeholder="Search players...">
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle">
                <thead class="bg-light text-uppercase text-muted text-xs font-bold tracking-wider">
                    <tr>
                        <th class="border-top-0 py-3 pl-5 w-16 text-center">#</th>
                        <th class="border-top-0 py-3">Player Name</th>
                        <th class="border-top-0 py-3">Position</th>
                        <th class="border-top-0 py-3 text-center">Age</th>
                        <th class="border-top-0 py-3 text-center">Status</th>
                        <th class="border-top-0 py-3 text-right pr-5">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="hover-bg-light transition group">
                        <td class="py-4 pl-5 text-center"><strong class="text-dark text-lg font-bold">10</strong></td>
                        <td>
                            <div class="flex items-center">
                                <div class="avatar avatar-sm bg-primary text-white rounded-circle mr-3 flex items-center justify-center shadow-sm font-bold" style="width:36px;height:36px;">JD</div>
                                <div>
                                    <a href="/admin/players/1" class="text-dark font-bold hover-text-primary transition d-block">John Doe</a>
                                    <span class="text-xs text-muted">#PL-1001</span>
                                </div>
                            </div>
                        </td>
                        <td><span class="font-medium text-dark">Forward</span></td>
                        <td class="text-center text-muted font-medium">18</td>
                        <td class="text-center"><span class="badge badge-success rounded-pill px-3 py-1">Active</span></td>
                        <td class="text-right pr-5">
                            <button class="btn btn-sm btn-light text-danger hover-bg-danger hover-text-white transition rounded-circle opacity-0 group-hover-opacity-100 p-0 flex items-center justify-center" style="width: 32px; height: 32px;" title="Remove from Roster"><i class="fas fa-times"></i></button>
                        </td>
                    </tr>
                    <tr class="hover-bg-light transition group">
                        <td class="py-4 pl-5 text-center"><strong class="text-dark text-lg font-bold">7</strong></td>
                        <td>
                            <div class="flex items-center">
                                <div class="avatar avatar-sm bg-info text-white rounded-circle mr-3 flex items-center justify-center shadow-sm font-bold" style="width:36px;height:36px;">AS</div>
                                <div>
                                    <a href="/admin/players/4" class="text-dark font-bold hover-text-primary transition d-block">Alex Smith</a>
                                    <span class="text-xs text-muted">#PL-1045</span>
                                </div>
                            </div>
                        </td>
                        <td><span class="font-medium text-dark">Midfielder</span></td>
                        <td class="text-center text-muted font-medium">17</td>
                        <td class="text-center"><span class="badge badge-success rounded-pill px-3 py-1">Active</span></td>
                        <td class="text-right pr-5">
                            <button class="btn btn-sm btn-light text-danger hover-bg-danger hover-text-white transition rounded-circle opacity-0 group-hover-opacity-100 p-0 flex items-center justify-center" style="width: 32px; height: 32px;" title="Remove from Roster"><i class="fas fa-times"></i></button>
                        </td>
                    </tr>
                    <tr class="hover-bg-light transition group bg-light-warning" style="opacity: 0.9;">
                        <td class="py-4 pl-5 text-center"><strong class="text-dark text-lg font-bold">1</strong></td>
                        <td>
                            <div class="flex items-center">
                                <div class="avatar avatar-sm bg-secondary text-white rounded-circle mr-3 flex items-center justify-center shadow-sm font-bold" style="width:36px;height:36px;">MJ</div>
                                <div>
                                    <a href="/admin/players/5" class="text-dark font-bold hover-text-primary transition d-block">Mike Johnson</a>
                                    <span class="text-xs text-muted">#PL-1012</span>
                                </div>
                            </div>
                        </td>
                        <td><span class="font-medium text-dark">Goalkeeper</span></td>
                        <td class="text-center text-muted font-medium">18</td>
                        <td class="text-center"><span class="badge bg-white border border-warning text-warning rounded-pill px-3 py-1"><i class="fas fa-briefcase-medical mr-1"></i> Injured Res</span></td>
                        <td class="text-right pr-5">
                            <button class="btn btn-sm btn-light text-danger hover-bg-danger hover-text-white transition rounded-circle opacity-0 group-hover-opacity-100 p-0 flex items-center justify-center" style="width: 32px; height: 32px;" title="Remove from Roster"><i class="fas fa-times"></i></button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
