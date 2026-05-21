<?php 
$pageTitle = 'Manage Coaches';
include __DIR__ . '/../../layouts/admin.php'; 
?>

<div class="page-header flex justify-between items-center mb-4">
    <div class="header-content">
        <h1 class="text-2xl font-bold m-0">Coaches</h1>
        <p class="text-muted m-0 mt-1">Manage team coaches and staff personnel</p>
    </div>
    <div class="header-actions">
        <button class="btn btn-primary rounded-pill px-4 shadow-sm"><i class="fas fa-plus mr-2"></i> Add Coach</button>
    </div>
</div>

<div class="card shadow-sm border-0 rounded-lg overflow-hidden">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle">
                <thead class="bg-light text-uppercase text-muted text-sm font-medium">
                    <tr>
                        <th class="border-top-0 py-3 pl-4">Coach Info</th>
                        <th class="border-top-0 py-3">Assigned Team</th>
                        <th class="border-top-0 py-3">Contact</th>
                        <th class="border-top-0 py-3">License Level</th>
                        <th class="border-top-0 py-3">Status</th>
                        <th class="border-top-0 py-3 text-right pr-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="hover-bg-light transition">
                        <td class="py-3 pl-4">
                            <div class="flex items-center">
                                <img src="https://ui-avatars.com/api/?name=Coach+Smith&background=0D8ABC&color=fff&rounded=true&size=40" alt="Avatar" class="rounded-circle mr-3 shadow-sm">
                                <div>
                                    <strong class="text-dark d-block">Coach Smith</strong>
                                    <span class="text-muted text-xs">Head Coach</span>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="flex items-center">
                                <span class="w-2 h-2 rounded-circle bg-danger mr-2"></span>
                                <span class="font-medium text-dark">Dragons</span>
                            </div>
                        </td>
                        <td><a href="mailto:smith@example.com" class="text-muted hover-text-primary transition"><i class="fas fa-envelope mr-1"></i> smith@example.com</a></td>
                        <td><span class="badge bg-dark text-white rounded px-2 py-1">A-License</span></td>
                        <td><span class="badge badge-success rounded-pill px-3 py-1"><i class="fas fa-circle text-xs mr-1" style="font-size: 8px;"></i> Active</span></td>
                        <td class="text-right pr-4">
                            <a href="/admin/coaches/1" class="btn btn-sm btn-light text-primary hover-bg-primary hover-text-white transition rounded-pill px-3">Details</a>
                        </td>
                    </tr>
                    <tr class="hover-bg-light transition">
                        <td class="py-3 pl-4">
                            <div class="flex items-center">
                                <img src="https://ui-avatars.com/api/?name=Alan+Brown&background=10B981&color=fff&rounded=true&size=40" alt="Avatar" class="rounded-circle mr-3 shadow-sm">
                                <div>
                                    <strong class="text-dark d-block">Alan Brown</strong>
                                    <span class="text-muted text-xs">Assistant Coach</span>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="flex items-center">
                                <span class="w-2 h-2 rounded-circle bg-warning mr-2"></span>
                                <span class="font-medium text-dark">Tigers</span>
                            </div>
                        </td>
                        <td><a href="mailto:alan.b@example.com" class="text-muted hover-text-primary transition"><i class="fas fa-envelope mr-1"></i> alan.b@example.com</a></td>
                        <td><span class="badge bg-secondary text-white rounded px-2 py-1">B-License</span></td>
                        <td><span class="badge badge-success rounded-pill px-3 py-1"><i class="fas fa-circle text-xs mr-1" style="font-size: 8px;"></i> Active</span></td>
                        <td class="text-right pr-4">
                            <a href="/admin/coaches/2" class="btn btn-sm btn-light text-primary hover-bg-primary hover-text-white transition rounded-pill px-3">Details</a>
                        </td>
                    </tr>
                    <tr class="hover-bg-light transition bg-light-warning" style="opacity: 0.95;">
                        <td class="py-3 pl-4">
                            <div class="flex items-center">
                                <img src="https://ui-avatars.com/api/?name=Emily+Jones&background=F59E0B&color=fff&rounded=true&size=40" alt="Avatar" class="rounded-circle mr-3 shadow-sm">
                                <div>
                                    <strong class="text-dark d-block">Emily Jones</strong>
                                    <span class="text-muted text-xs">New Applicant</span>
                                </div>
                            </div>
                        </td>
                        <td><span class="text-muted italic"><i class="fas fa-exclamation-circle mr-1"></i> Unassigned</span></td>
                        <td><a href="mailto:emily.j@example.com" class="text-muted hover-text-primary transition"><i class="fas fa-envelope mr-1"></i> emily.j@example.com</a></td>
                        <td><span class="badge bg-secondary text-white rounded px-2 py-1">C-License</span></td>
                        <td><span class="badge badge-warning rounded-pill px-3 py-1"><i class="fas fa-clock text-xs mr-1"></i> Pending Review</span></td>
                        <td class="text-right pr-4">
                            <a href="/admin/coaches/3" class="btn btn-sm btn-warning text-white transition rounded-pill px-3 shadow-sm">Review</a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
