<?php 
$pageTitle = 'Manage Teams';
include __DIR__ . '/../../layouts/admin.php'; 
?>

<div class="page-header flex justify-between items-center mb-5">
    <div class="header-content">
        <h1 class="text-3xl font-bold m-0">Teams</h1>
        <p class="text-muted m-0 mt-1">Manage divisions, team rosters, and staff assignments</p>
    </div>
    <div class="header-actions flex gap-3">
        <div class="search-box relative">
            <i class="fas fa-search absolute text-muted" style="left: 12px; top: 50%; transform: translateY(-50%);"></i>
            <input type="text" class="form-control pl-5 rounded-pill bg-white shadow-sm border-0" placeholder="Search teams...">
        </div>
        <a href="/admin/teams/create" class="btn btn-primary rounded-pill px-4 shadow-sm flex items-center"><i class="fas fa-plus mr-2"></i> Add Team</a>
    </div>
</div>

<div class="grid grid-3 gap-5">
    <!-- Team Card 1 -->
    <div class="card team-card shadow-sm border-0 rounded-xl overflow-hidden hover-shadow-lg transition transform hover-translate-y-1 relative group cursor-pointer" onclick="window.location.href='/admin/teams/1'">
        <div class="h-2 bg-danger w-full absolute top-0 left-0"></div>
        <div class="card-header border-0 bg-white pt-4 pb-0 flex justify-between items-start">
            <div class="avatar avatar-lg bg-danger-light text-danger rounded-lg flex items-center justify-center text-2xl font-bold shadow-sm" style="width:72px;height:72px;">
                <i class="fas fa-fire text-3xl"></i>
            </div>
            <div class="dropdown">
                <button class="btn btn-sm btn-icon text-muted hover-bg-light rounded-circle" onclick="event.stopPropagation();"><i class="fas fa-ellipsis-v"></i></button>
            </div>
        </div>
        <div class="card-body pt-4 pb-3">
            <h3 class="text-2xl font-bold mb-1 text-dark">Dragons</h3>
            <span class="badge bg-light text-dark border rounded-pill px-3 py-1 mb-4 font-medium">U-18 Division</span>
            
            <div class="text-sm text-muted mb-4 space-y-2">
                <div class="flex items-center"><i class="fas fa-user-tie w-6 text-center text-primary"></i> <span class="font-medium text-dark">Coach Smith</span></div>
                <div class="flex items-center justify-between">
                    <div><i class="fas fa-users w-6 text-center text-primary"></i> <strong class="text-dark">18</strong> / 22 Players</div>
                    <span class="text-xs text-success font-bold">81% Full</span>
                </div>
            </div>
            
            <div class="progress rounded-pill bg-light" style="height: 8px;">
                <div class="progress-bar bg-success rounded-pill" style="width: 81%;"></div>
            </div>
        </div>
        <div class="card-footer bg-white border-top border-light py-3 text-center group-hover-bg-light transition">
            <span class="text-primary font-bold text-sm uppercase tracking-wider">View Roster <i class="fas fa-arrow-right ml-1 transform group-hover-translate-x-1 transition"></i></span>
        </div>
    </div>

    <!-- Team Card 2 -->
    <div class="card team-card shadow-sm border-0 rounded-xl overflow-hidden hover-shadow-lg transition transform hover-translate-y-1 relative group cursor-pointer" onclick="window.location.href='/admin/teams/2'">
        <div class="h-2 bg-warning w-full absolute top-0 left-0"></div>
        <div class="card-header border-0 bg-white pt-4 pb-0 flex justify-between items-start">
            <div class="avatar avatar-lg bg-warning-light text-warning rounded-lg flex items-center justify-center text-2xl font-bold shadow-sm" style="width:72px;height:72px;">
                <i class="fas fa-paw text-3xl"></i>
            </div>
            <div class="dropdown">
                <button class="btn btn-sm btn-icon text-muted hover-bg-light rounded-circle" onclick="event.stopPropagation();"><i class="fas fa-ellipsis-v"></i></button>
            </div>
        </div>
        <div class="card-body pt-4 pb-3">
            <h3 class="text-2xl font-bold mb-1 text-dark">Tigers</h3>
            <span class="badge bg-light text-dark border rounded-pill px-3 py-1 mb-4 font-medium">U-16 Division</span>
            
            <div class="text-sm text-muted mb-4 space-y-2">
                <div class="flex items-center"><i class="fas fa-user-tie w-6 text-center text-primary"></i> <span class="font-medium text-dark">Alan Brown</span></div>
                <div class="flex items-center justify-between">
                    <div><i class="fas fa-users w-6 text-center text-primary"></i> <strong class="text-dark">22</strong> / 22 Players</div>
                    <span class="text-xs text-danger font-bold">100% Full</span>
                </div>
            </div>
            
            <div class="progress rounded-pill bg-light" style="height: 8px;">
                <div class="progress-bar bg-danger rounded-pill" style="width: 100%;"></div>
            </div>
        </div>
        <div class="card-footer bg-white border-top border-light py-3 text-center group-hover-bg-light transition">
            <span class="text-primary font-bold text-sm uppercase tracking-wider">View Roster <i class="fas fa-arrow-right ml-1 transform group-hover-translate-x-1 transition"></i></span>
        </div>
    </div>
    
    <!-- Team Card 3 -->
    <div class="card team-card shadow-sm border-0 rounded-xl overflow-hidden hover-shadow-lg transition transform hover-translate-y-1 relative group cursor-pointer" onclick="window.location.href='/admin/teams/3'">
        <div class="h-2 bg-success w-full absolute top-0 left-0"></div>
        <div class="card-header border-0 bg-white pt-4 pb-0 flex justify-between items-start">
            <div class="avatar avatar-lg bg-success-light text-success rounded-lg flex items-center justify-center text-2xl font-bold shadow-sm" style="width:72px;height:72px;">
                <i class="fas fa-feather-alt text-3xl"></i>
            </div>
            <div class="dropdown">
                <button class="btn btn-sm btn-icon text-muted hover-bg-light rounded-circle" onclick="event.stopPropagation();"><i class="fas fa-ellipsis-v"></i></button>
            </div>
        </div>
        <div class="card-body pt-4 pb-3">
            <h3 class="text-2xl font-bold mb-1 text-dark">Eagles</h3>
            <span class="badge bg-light text-dark border rounded-pill px-3 py-1 mb-4 font-medium">U-14 Division</span>
            
            <div class="text-sm text-muted mb-4 space-y-2">
                <div class="flex items-center"><i class="fas fa-user-tie w-6 text-center text-warning"></i> <span class="font-medium text-warning italic">Pending Assignment</span></div>
                <div class="flex items-center justify-between">
                    <div><i class="fas fa-users w-6 text-center text-primary"></i> <strong class="text-dark">5</strong> / 20 Players</div>
                    <span class="text-xs text-warning font-bold">25% Full</span>
                </div>
            </div>
            
            <div class="progress rounded-pill bg-light" style="height: 8px;">
                <div class="progress-bar bg-warning rounded-pill" style="width: 25%;"></div>
            </div>
        </div>
        <div class="card-footer bg-white border-top border-light py-3 text-center group-hover-bg-light transition">
            <span class="text-primary font-bold text-sm uppercase tracking-wider">View Roster <i class="fas fa-arrow-right ml-1 transform group-hover-translate-x-1 transition"></i></span>
        </div>
    </div>
</div>
