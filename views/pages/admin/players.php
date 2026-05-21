<?php 
$pageTitle = 'Manage Players';
include __DIR__ . '/../../layouts/admin.php'; 
?>

<div class="page-header flex justify-between items-center mb-4">
    <div class="header-content">
        <h1 class="text-2xl font-bold m-0">Players</h1>
        <p class="text-muted m-0 mt-1">Manage all registered players in the system</p>
    </div>
    <div class="header-actions flex items-center gap-3">
        <div class="search-box relative">
            <i class="fas fa-search absolute text-muted" style="left: 12px; top: 50%; transform: translateY(-50%);"></i>
            <input type="text" class="form-control pl-5 rounded-pill" placeholder="Search players...">
        </div>
        <button class="btn btn-outline-primary shadow-sm"><i class="fas fa-file-export mr-2"></i> Export CSV</button>
    </div>
</div>

<div class="card shadow-sm border-0 rounded-lg overflow-hidden">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-striped table-hover mb-0 align-middle">
                <thead class="bg-light text-uppercase text-muted text-sm font-medium">
                    <tr>
                        <th class="border-top-0 py-3">Player</th>
                        <th class="border-top-0 py-3">Team</th>
                        <th class="border-top-0 py-3">Position</th>
                        <th class="border-top-0 py-3">Registration Date</th>
                        <th class="border-top-0 py-3">Status</th>
                        <th class="border-top-0 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="py-3">
                            <div class="flex items-center">
                                <div class="avatar avatar-sm bg-primary text-white rounded-circle mr-3 flex items-center justify-center shadow-sm" style="width: 40px; height: 40px; font-weight: bold;">JD</div>
                                <div>
                                    <strong class="text-dark d-block">John Doe</strong>
                                    <span class="text-muted text-xs">#PL-1001</span>
                                </div>
                            </div>
                        </td>
                        <td><span class="font-medium text-dark">Dragons</span></td>
                        <td>Forward</td>
                        <td class="text-muted">Oct 15, 2023</td>
                        <td><span class="badge badge-success rounded-pill px-3 py-1">Approved</span></td>
                        <td class="text-right">
                            <a href="/admin/players/1" class="btn btn-sm btn-light text-primary hover-bg-primary hover-text-white transition rounded-pill px-3">View Details</a>
                        </td>
                    </tr>
                    <tr>
                        <td class="py-3">
                            <div class="flex items-center">
                                <div class="avatar avatar-sm bg-info text-white rounded-circle mr-3 flex items-center justify-center shadow-sm" style="width: 40px; height: 40px; font-weight: bold;">MJ</div>
                                <div>
                                    <strong class="text-dark d-block">Mike Johnson</strong>
                                    <span class="text-muted text-xs">#PL-1002</span>
                                </div>
                            </div>
                        </td>
                        <td><span class="text-muted italic">Unassigned</span></td>
                        <td>Midfielder</td>
                        <td class="text-muted">Oct 16, 2023</td>
                        <td><span class="badge badge-warning rounded-pill px-3 py-1">Pending</span></td>
                        <td class="text-right">
                            <a href="/admin/players/2" class="btn btn-sm btn-light text-primary hover-bg-primary hover-text-white transition rounded-pill px-3">View Details</a>
                        </td>
                    </tr>
                    <tr>
                        <td class="py-3">
                            <div class="flex items-center">
                                <div class="avatar avatar-sm bg-danger text-white rounded-circle mr-3 flex items-center justify-center shadow-sm" style="width: 40px; height: 40px; font-weight: bold;">SW</div>
                                <div>
                                    <strong class="text-dark d-block">Sarah Williams</strong>
                                    <span class="text-muted text-xs">#PL-1003</span>
                                </div>
                            </div>
                        </td>
                        <td><span class="font-medium text-dark">Tigers</span></td>
                        <td>Defender</td>
                        <td class="text-muted">Oct 14, 2023</td>
                        <td><span class="badge badge-danger rounded-pill px-3 py-1">Rejected</span></td>
                        <td class="text-right">
                            <a href="/admin/players/3" class="btn btn-sm btn-light text-primary hover-bg-primary hover-text-white transition rounded-pill px-3">View Details</a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer bg-white border-top py-3 flex justify-between items-center">
        <span class="text-muted text-sm">Showing 1 to 3 of 1,245 players</span>
        <div class="pagination flex gap-1">
            <button class="btn btn-sm btn-outline-light text-muted disabled rounded-pill px-3">Previous</button>
            <button class="btn btn-sm btn-primary rounded-circle" style="width: 32px; height: 32px;">1</button>
            <button class="btn btn-sm btn-outline-light text-dark rounded-circle hover-bg-light" style="width: 32px; height: 32px;">2</button>
            <button class="btn btn-sm btn-outline-light text-dark rounded-circle hover-bg-light" style="width: 32px; height: 32px;">3</button>
            <span class="px-2 py-1 text-muted">...</span>
            <button class="btn btn-sm btn-outline-light text-dark rounded-pill px-3 hover-bg-light">Next</button>
        </div>
    </div>
</div>
