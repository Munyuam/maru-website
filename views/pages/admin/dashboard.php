<?php 
$pageTitle = 'Admin Dashboard';
include __DIR__ . '/../../layouts/admin.php'; 
?>

<div class="page-header mb-4">
    <div class="header-content">
        <h1 class="text-2xl font-bold">Admin Dashboard</h1>
        <p class="text-muted">Overview of the MARU Registration System</p>
    </div>
</div>

<div class="stats-grid grid grid-4 gap-4 mb-4">
    <div class="card stat-card shadow-sm border-0">
        <div class="card-body flex items-center justify-between p-4">
            <div>
                <p class="stat-label text-muted mb-1 font-medium text-sm uppercase">Total Players</p>
                <h3 class="stat-value text-3xl font-bold mb-0">1,245</h3>
            </div>
            <div class="stat-icon text-primary bg-primary-light rounded-circle p-3 flex items-center justify-center" style="width: 48px; height: 48px;">
                <i class="fas fa-users text-xl"></i>
            </div>
        </div>
    </div>
    <div class="card stat-card shadow-sm border-0">
        <div class="card-body flex items-center justify-between p-4">
            <div>
                <p class="stat-label text-muted mb-1 font-medium text-sm uppercase">Pending Approvals</p>
                <h3 class="stat-value text-3xl font-bold mb-0">42</h3>
            </div>
            <div class="stat-icon text-warning bg-warning-light rounded-circle p-3 flex items-center justify-center" style="width: 48px; height: 48px;">
                <i class="fas fa-clock text-xl"></i>
            </div>
        </div>
    </div>
    <div class="card stat-card shadow-sm border-0">
        <div class="card-body flex items-center justify-between p-4">
            <div>
                <p class="stat-label text-muted mb-1 font-medium text-sm uppercase">Total Teams</p>
                <h3 class="stat-value text-3xl font-bold mb-0">28</h3>
            </div>
            <div class="stat-icon text-success bg-success-light rounded-circle p-3 flex items-center justify-center" style="width: 48px; height: 48px;">
                <i class="fas fa-shield-alt text-xl"></i>
            </div>
        </div>
    </div>
    <div class="card stat-card shadow-sm border-0">
        <div class="card-body flex items-center justify-between p-4">
            <div>
                <p class="stat-label text-muted mb-1 font-medium text-sm uppercase">Active Coaches</p>
                <h3 class="stat-value text-3xl font-bold mb-0">35</h3>
            </div>
            <div class="stat-icon text-info bg-info-light rounded-circle p-3 flex items-center justify-center" style="width: 48px; height: 48px;">
                <i class="fas fa-user-tie text-xl"></i>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-2 gap-4">
    <div class="card shadow-sm border-0">
        <div class="card-header border-bottom flex justify-between items-center bg-white py-3">
            <h2 class="text-lg font-bold m-0">Recent Activity</h2>
            <button class="btn btn-sm btn-outline-secondary">View All</button>
        </div>
        <div class="card-body p-0">
            <div class="activity-list">
                <div class="activity-item p-3 border-bottom flex items-start hover-bg-light transition">
                    <div class="avatar avatar-sm bg-primary text-white rounded-circle mr-3 flex-shrink-0 flex items-center justify-center" style="width: 36px; height: 36px;">JD</div>
                    <div class="flex-1">
                        <div class="flex justify-between items-center mb-1">
                            <strong class="text-dark">John Doe</strong>
                            <small class="text-muted">10 mins ago</small>
                        </div>
                        <p class="text-sm text-muted m-0">Registered as a Player and submitted documentation.</p>
                    </div>
                </div>
                <div class="activity-item p-3 border-bottom flex items-start hover-bg-light transition">
                    <div class="avatar avatar-sm bg-info text-white rounded-circle mr-3 flex-shrink-0 flex items-center justify-center" style="width: 36px; height: 36px;">CS</div>
                    <div class="flex-1">
                        <div class="flex justify-between items-center mb-1">
                            <strong class="text-dark">Coach Smith</strong>
                            <small class="text-muted">1 hour ago</small>
                        </div>
                        <p class="text-sm text-muted m-0">Updated team roster for the Dragons.</p>
                    </div>
                </div>
                <div class="activity-item p-3 flex items-start hover-bg-light transition">
                    <div class="avatar avatar-sm bg-success text-white rounded-circle mr-3 flex-shrink-0 flex items-center justify-center" style="width: 36px; height: 36px;">SW</div>
                    <div class="flex-1">
                        <div class="flex justify-between items-center mb-1">
                            <strong class="text-dark">Sarah Williams</strong>
                            <small class="text-muted">2 hours ago</small>
                        </div>
                        <p class="text-sm text-muted m-0">Uploaded medical clearance form.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-header border-bottom flex justify-between items-center bg-white py-3">
            <h2 class="text-lg font-bold m-0">Pending Actions</h2>
            <button class="btn btn-sm btn-outline-secondary">Manage</button>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover m-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="border-top-0">Action</th>
                            <th class="border-top-0">User</th>
                            <th class="border-top-0">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="font-medium text-dark"><i class="fas fa-file-alt text-primary mr-2"></i> Document Verification</td>
                            <td>Mike Johnson</td>
                            <td><span class="badge badge-warning rounded-pill px-2 py-1">Pending</span></td>
                        </tr>
                        <tr>
                            <td class="font-medium text-dark"><i class="fas fa-credit-card text-success mr-2"></i> Payment Approval</td>
                            <td>Sarah Williams</td>
                            <td><span class="badge badge-warning rounded-pill px-2 py-1">Pending</span></td>
                        </tr>
                        <tr>
                            <td class="font-medium text-dark"><i class="fas fa-users text-info mr-2"></i> Team Assignment</td>
                            <td>David Brown</td>
                            <td><span class="badge badge-danger rounded-pill px-2 py-1">Action Required</span></td>
                        </tr>
                        <tr>
                            <td class="font-medium text-dark"><i class="fas fa-id-card text-secondary mr-2"></i> Profile Review</td>
                            <td>Alex Turner</td>
                            <td><span class="badge badge-warning rounded-pill px-2 py-1">Pending</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
